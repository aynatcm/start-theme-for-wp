#!/usr/bin/env node

import inquirer from 'inquirer'
import fs from 'fs-extra'
import path from 'path'
import { fileURLToPath } from 'url'
import { execSync } from 'child_process'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

async function findWpThemesPath(startPath = process.cwd()) {
  let currentPath = startPath

  while (true) {
    const wpConfigPath = path.join(currentPath, 'wp-config.php')
    if (fs.existsSync(wpConfigPath)) {
      const themesPath = path.join(currentPath, 'wp-content', 'themes')
      if (!fs.existsSync(themesPath)) {
        await fs.mkdirp(themesPath)
      }
      return themesPath
    }

    const parentPath = path.dirname(currentPath)
    if (parentPath === currentPath) {
      throw new Error('No se encontró una instalación de WordPress (wp-config.php no encontrado).')
    }

    currentPath = parentPath
  }
}

async function main() {
  console.log('\n🎨 Bienvenido al tema WordPress Maruchan hecho por Kronoscode\n')

  const answers = await inquirer.prompt([
    {
      name: 'projectName',
      message: 'Nombre del tema:',
      default: 'mi-tema'
    },
    {
      name: 'siteDomain',
      message: 'Dominio local del sitio (ej. new-start-theme.local):',
      default: 'new-start-theme.local'
    },
    {
      name: 'authorDescription',
      message: 'Descripción del autor:',
      default: 'Starter theme for wordpress developed by kronoscode team, this theme uses acf pro for work, it has his own page builder, custom animations, custom post types and a vue setup ready for use.'
    }
  ])

  let themesPath
  try {
    themesPath = await findWpThemesPath()
  } catch (error) {
    console.error('❌ Error:', error.message)
    return
  }

  const targetDir = path.join(themesPath, answers.projectName)

  console.log(`📁 Creando tema en: ${targetDir}`)
  await fs.copy(path.join(__dirname, '../new-start-theme'), targetDir)

  const phpSafeName = answers.projectName.replace(/[\s\-]+/g, '_')

  const replacements = {
    PROJECT_NAME: answers.projectName,         
    PHP_SAFE_NAME: phpSafeName,                 
    SITE_DOMAIN: answers.siteDomain,
    AUTHOR_NAME: answers.authorName,
    AUTHOR_DESCRIPTION: answers.authorDescription
  }


  const replaceInFile = async (filePath) => {
    let content = await fs.readFile(filePath, 'utf8')
    for (const [key, value] of Object.entries(replacements)) {
      const regex = new RegExp(`__${key}__`, 'g')
      content = content.replace(regex, value)
    }
    await fs.writeFile(filePath, content)
  }

  const filesToUpdate = ['style.css', 'package.json', 'webpack/webpack.common.js', 'includes/base/scripts-and-styles.php','webpack/webpack.dev.js']
  for (const file of filesToUpdate) {
    const filePath = path.join(targetDir, file)
    if (fs.existsSync(filePath)) {
      await replaceInFile(filePath)
    }
  }

  console.log('📦 Suave, tamos instalando dependencias...')
  execSync('npm install', { cwd: targetDir, stdio: 'inherit' })

  console.log('\n✅ ¡Ya se instalo todo, detonate mi dog!\n')
  console.log(`🧩 Actívalo en WordPress y usa: npm run dev en ${targetDir}`)
}

main()
