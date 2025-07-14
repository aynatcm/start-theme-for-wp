const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const {VueLoaderPlugin} = require("vue-loader");

const slugTheme = '__PROJECT_NAME__';

module.exports = {
    mode: 'production',
    target: 'web',

    // Definimos la carpeta raíz (context) en el tema (ajustado para evitar doble nesting)
    context: path.resolve(__dirname, '..'),

    // Entradas relativas al context
    entry: [
        './assets/js/index.js',
        './assets/sass/index.scss'
    ],

    // Salida dentro de assets/dist
    output: {
        path: path.resolve(__dirname, '..', 'assets', 'dist'),
        // Ajusta publicPath para que coincida con la ubicación de tus assets desde la raíz del tema
        publicPath: '../../',
        filename: 'js/[name].js',
        assetModuleFilename: 'images/[name][ext]'
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
        new VueLoaderPlugin(),
    ],

    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
            },
            {
                test: /\.ts$/,
                use: 'ts-loader',
            },
            {
                test: /\.html$/i,
                loader: 'html-loader',
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'postcss-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: {
                                outputStyle: 'expanded',
                            },
                        },
                    },
                ],
            },
            {
                test: /\.(png|jpg|jpeg|gif|svg|webp)$/,
                type: 'asset/resource',
                generator: {
                    // Asegúrate de que las imágenes se emitan en la carpeta 'images' dentro de 'dist'
                    filename: 'images/[name][ext]',
                    publicPath: '../../' // También ajusta el publicPath aquí si es necesario
                }
            },
        ],
    },

    resolve: {
        modules: ['node_modules'],
        extensions: ['.js', '.jsx', '.ts', '.vue', '.css', '.scss'],
    },
};