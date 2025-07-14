<script setup>
import {generalStore} from "../js/stores/generalStore";
import {onBeforeMount, computed, ref} from 'vue';
import {jsPDF} from 'jspdf';
import autoTable from 'jspdf-autotable';


const name = ref('');
const email = ref('');
const status = ref('');

function generatePDF() {
  const doc = new jsPDF();

  doc.setFontSize(16);
  doc.text('Financing Details', 14, 20);

  autoTable(doc, {
    startY: 25,
    theme: 'grid',
    head: [['Description', 'Amount']],
    body: [
      ['Property Value', formatNumber(useGeneralStore.priceHouse) + ' $'],
      ['(-) Down Payment', formatNumber(useGeneralStore.priceHouse * (useGeneralStore.downPayment / 100)) + ' $'],
      ['(=) Amount to Finance', formatNumber(valueToFinance.value) + ' $'],
    ],
    headStyles: {
      fillColor: [27, 179, 188],
      textColor: [0, 0, 0],
      halign: 'left',
    },
    bodyStyles: {
      textColor: [0, 0, 0],
      halign: 'left',
    },
    styles: {
      fontSize: 11,
      cellPadding: 4,
    }
  });

  doc.text('Fees and Insurance', 14, doc.lastAutoTable.finalY + 10);

  autoTable(doc, {
    startY: doc.lastAutoTable.finalY + 15,
    theme: 'grid',
    head: [['Description', 'Amount']],
    body: [
      ['Approximate monthly payment without insurance', fixedFeeWithoutInsurance.value + ' $'],
      ['Life insurance on debit balance', formatNumber(svsdCalculated.value) + ' $'],
      ['Approximate monthly payment with insurance', fixedFeeWithInsurance.value + ' $'],
    ],
    headStyles: {
      fillColor: [27, 179, 188],
      textColor: [0, 0, 0],
      halign: 'left',
    },
    bodyStyles: {
      textColor: [0, 0, 0],
      halign: 'left',
    },
    styles: {
      fontSize: 11,
      cellPadding: 4,
    }
  });

  doc.save('financing-details.pdf');
}


const useGeneralStore = generalStore();

onBeforeMount(async () => {
  await useGeneralStore.fetchData();
});

function formatNumber(value) {
  if (typeof value !== 'number') {
    value = parseFloat(value);
    if (isNaN(value)) return '';
  }
  value = Math.round(value * 100) / 100;

  const parts = value.toString().split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  return parts.join('.');
}

const valueToFinance = computed(() => useGeneralStore.priceHouse - (useGeneralStore.priceHouse * (useGeneralStore.downPayment / 100)));

const monthlyInterestRate = computed(() => useGeneralStore.annualInterestRate / 12 / 100);

const numberOfPayments = computed(() => useGeneralStore.deadline * 12);

const svsdCalculated = computed(() => useGeneralStore.priceHouse * useGeneralStore.dataCalculator.svsd_factor);

const fixedFeeWithoutInsurance = computed(() => {
  if (monthlyInterestRate.value === 0) {
    return formatNumber(valueToFinance.value / numberOfPayments.value);
  } else {
    const numerator = monthlyInterestRate.value * Math.pow(1 + monthlyInterestRate.value, numberOfPayments.value);
    const denominator = Math.pow(1 + monthlyInterestRate.value, numberOfPayments.value) - 1;
    return formatNumber(valueToFinance.value * (numerator / denominator));
  }
});

const fixedFeeWithInsurance = computed(() => {
  const payment = parseFloat(fixedFeeWithoutInsurance.value.replace(',', '')) + svsdCalculated.value;
  return formatNumber(payment + useGeneralStore.dataCalculator.biac);
});


function onSubmit() {
  console.log('Se mando el formulario')
}
</script>

<template>
  <div class="container--estimated-payments">

    <h2 class="title--estimated-payments">Estimated information of payment</h2>

    <div v-if="!useGeneralStore.isDataLoaded" class="container--loading-calculator">Loading...</div>

    <div v-else class="container--payment-details">
      <table class="payment-table">
        <thead>
        <tr>
          <th colspan="2">Financing Details</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>Property Value</td>
          <td>{{ formatNumber(useGeneralStore.priceHouse) }} $</td>
        </tr>
        <tr>
          <td>(-) Down Payment</td>
          <td>{{ formatNumber(useGeneralStore.priceHouse * (useGeneralStore.downPayment / 100)) }} $</td>
        </tr>
        <tr>
          <td>(=) Amount to Finance</td>
          <td>{{ formatNumber(valueToFinance) }} $</td>
        </tr>
        </tbody>
      </table>

      <table class="payment-table">
        <thead>
        <tr>
          <th colspan="2">Fees and insurance</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>Approximate monthly payment without insurance</td>
          <td>{{ fixedFeeWithoutInsurance }} $</td>
        </tr>
        <tr>
          <td>Life insurance on debit balance</td>
          <td>{{ formatNumber(svsdCalculated) }} $</td>
        </tr>
        <tr>
          <td>Approximate monthly payment with insurance</td>
          <td>{{ fixedFeeWithInsurance }} $</td>
        </tr>
        </tbody>
      </table>

      <div class="container--cta-calculator">

        <form @submit.prevent="onSubmit" class="form--calculator-zoho">
          <input v-model="name" required placeholder="First and Last Name"/>
          <input type="email" v-model="email" required placeholder="JohnDoe@example.com"/>
          <input type="submit" value="Get Started"/>
          <p v-if="status">{{ status }}</p>
        </form>

        <button @click="generatePDF" class="cta--dowload-quote">Download Your Quote
          <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10.4993 13.4809L7.55018 10.5326L8.14018 9.93258L10.0827 11.8751V4.66675H10.916V11.8751L12.8577 9.93341L13.4485 10.5326L10.4993 13.4809ZM6.01268 16.3334C5.62879 16.3334 5.30852 16.2051 5.05185 15.9484C4.79518 15.6917 4.66657 15.3712 4.66602 14.9867V12.9676H5.49935V14.9867C5.49935 15.1151 5.55268 15.2329 5.65935 15.3401C5.76602 15.4473 5.88352 15.5006 6.01185 15.5001H14.9868C15.1146 15.5001 15.2321 15.4467 15.3393 15.3401C15.4466 15.2334 15.4999 15.1156 15.4993 14.9867V12.9676H16.3327V14.9867C16.3327 15.3706 16.2043 15.6909 15.9477 15.9476C15.691 16.2042 15.3705 16.3329 14.986 16.3334H6.01268Z"
                fill="#201F1E"/>
          </svg>
        </button>
      </div>
    </div>


  </div>
</template>
