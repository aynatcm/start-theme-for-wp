<script setup>
import {generalStore} from "../js/stores/generalStore";
import {onMounted, ref} from "vue";

const useGeneralStore = generalStore();

// Refs para almacenar los valores anteriores
const previousPriceHouse = ref(useGeneralStore.priceHouse);
const previousDownPayment = ref(useGeneralStore.downPayment);
const previousAnnualInterestRate = ref(useGeneralStore.annualInterestRate);
const previousDeadline = ref(useGeneralStore.deadline);

// Ref para el input de precio de la casa
const priceHouseInput = ref(null);

onMounted(async () => {
  await useGeneralStore.fetchData();

  previousPriceHouse.value = useGeneralStore.priceHouse;
  previousDownPayment.value = useGeneralStore.downPayment;
  previousAnnualInterestRate.value = useGeneralStore.annualInterestRate;
  previousDeadline.value = useGeneralStore.deadline;

  const spanElement = document.getElementById('propertyPrice');
  const rawText = spanElement?.textContent || '';
  const cleanedText = rawText.replace(/[^\d.]/g, ''); // elimina $ y comas
  const parsedValue = Number(cleanedText);

  if (parsedValue) {
    if (priceHouseInput.value) {
      useGeneralStore.priceHouse = parsedValue;
      priceHouseInput.value.value = parsedValue;
      priceHouseInput.value.readOnly = true;
    }
  } else {
    if (priceHouseInput.value) {
      priceHouseInput.value.readOnly = false;
    }
    useGeneralStore.priceHouse = previousPriceHouse.value;
  }
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

function validateAndUpdate(value, min, max, previousRef, storeKey) {
  const num = parseFloat(value);

  // Si no es un número válido, o si está vacío después de parsear,
  // restaura el valor anterior en el store y detiene la actualización.
  if (isNaN(num) || value === '') {
    useGeneralStore[storeKey] = previousRef.value;
    return;
  }

  if (num < min) {
    useGeneralStore[storeKey] = min;
    previousRef.value = min;
    return;
  }

  if (num > max) {
    useGeneralStore[storeKey] = max;
    previousRef.value = max;
    return;
  }

  useGeneralStore[storeKey] = num;
  previousRef.value = num;
}

function handlePriceHouseInput(event) {
  const inputValue = event.target.value;
  if (!inputValue.startsWith('-')) {
    validateAndUpdate(
        inputValue,
        useGeneralStore.dataCalculator.min_price_for_house,
        useGeneralStore.dataCalculator.max_price_for_house,
        previousPriceHouse,
        'priceHouse'
    );
  } else {
    // Restaurar al valor anterior si se intenta ingresar un signo negativo al inicio
    event.target.value = previousPriceHouse.value;
  }
}

function handleDownPaymentInput(event) {
  const inputValue = event.target.value;
  if (!inputValue.startsWith('-')) {
    validateAndUpdate(
        inputValue,
        useGeneralStore.dataCalculator.min_value_for_down_payment,
        useGeneralStore.dataCalculator.max_value_for_down_payment,
        previousDownPayment,
        'downPayment'
    );
  } else {
    event.target.value = previousDownPayment.value;
  }
}

function handleAnnualInterestRateInput(event) {
  const inputValue = event.target.value;
  if (!inputValue.startsWith('-')) {
    validateAndUpdate(
        inputValue,
        useGeneralStore.dataCalculator.min_annual_interest_rate,
        useGeneralStore.dataCalculator.max_annual_interest_rate,
        previousAnnualInterestRate,
        'annualInterestRate'
    );
  } else {
    event.target.value = previousAnnualInterestRate.value;
  }
}

function handleDeadlineInput(event) {
  const inputValue = event.target.value;
  if (!inputValue.startsWith('-')) {
    validateAndUpdate(
        inputValue,
        useGeneralStore.dataCalculator.min_value_for_loan_term,
        useGeneralStore.dataCalculator.max_value_for_loan_term,
        previousDeadline,
        'deadline'
    );
  } else {
    event.target.value = previousDeadline.value;
  }
}
</script>

<template>
  <div class="container--inputs-calculator">
    <h1 class="title--input-calculator">Property Payment Calculator</h1>
    <span class="subtitle--input-calculator">Estimate Your Monthly Payments</span>

    <div v-if="!useGeneralStore.isDataLoaded" class="container--loading-calculator">Loading...</div>

    <div v-else class="container--inputs">
      <div class="container--information-house">
        <label for="priceHouse">Property Value</label>
        <input
            ref="priceHouseInput"
            class="price--house"
            name="priceHouse"
            id="priceHouse"
            type="number"
            :min="useGeneralStore.dataCalculator.min_price_for_house"
            :max="useGeneralStore.dataCalculator.max_price_for_house"
            step="1000"
            @input="handlePriceHouseInput"
        />
        <span>{{ formatNumber(useGeneralStore.priceHouse) }}$</span>
      </div>

      <div class="container--down-payment">
        <label for="downPayment">Down Payment</label>
        <input
            class="down--payment"
            name="downPayment"
            id="downPayment"
            type="number"
            :min="useGeneralStore.dataCalculator.min_value_for_down_payment"
            :max="useGeneralStore.dataCalculator.max_value_for_down_payment"
            step="1"
            :value="useGeneralStore.downPayment"
            @input="handleDownPaymentInput"
        >
        <span>{{ formatNumber(useGeneralStore.downPayment) }}%</span>
      </div>

      <div class="container--annual-interest">
        <label for="annualInterest">Interest Rate</label>
        <input
            class="annual--interest"
            name="annualInterest"
            id="annualInterest"
            type="number"
            :min="useGeneralStore.dataCalculator.min_annual_interest_rate"
            :max="useGeneralStore.dataCalculator.max_annual_interest_rate"
            step="0.01"
            :value="useGeneralStore.annualInterestRate"
            @input="handleAnnualInterestRateInput"
        >
        <span>{{ formatNumber(useGeneralStore.annualInterestRate) }}%</span>
      </div>

      <div class="container--loan-term">
        <label for="deadline">Loan Term (Years)</label>
        <input
            class="deadline"
            name="deadline"
            id="deadline"
            type="number"
            :min="useGeneralStore.dataCalculator.min_value_for_loan_term"
            :max="useGeneralStore.dataCalculator.max_value_for_loan_term"
            step="1"
            :value="useGeneralStore.deadline"
            @input="handleDeadlineInput"
        >
        <span>{{ formatNumber(useGeneralStore.deadline) }} Years</span>
      </div>
    </div>
  </div>
</template>