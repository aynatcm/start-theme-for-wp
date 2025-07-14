import {defineStore} from "pinia";
import {ref} from "vue"


export const generalStore = defineStore('generalStore', () => {
    const dataCalculator = ref({})
    const isLoading = ref(false)
    const isDataLoaded = ref(false)
    const priceHouse = ref(10000)
    const downPayment = ref(10)
    const annualInterestRate = ref(9)
    const deadline = ref(10)
    const valuePayment = ref(0)

    const fetchData = async () => {
        isLoading.value = true;
        isDataLoaded.value = false;
        try {
            const res = await fetch('/wp-json/wp/v2/calculator_settings');
            if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);

            const result = await res.json();

            if (Object.keys(result).length > 0) {
                dataCalculator.value = result;
                priceHouse.value = result.min_price_for_house || 10000;
                downPayment.value = result.min_value_for_down_payment || 10
                annualInterestRate.value = result.min_annual_interest_rate || 9
                deadline.value = result.min_value_for_loan_term || 10
            }
            isDataLoaded.value = true;

        } catch (error) {
            console.log('Error fetching data: ', error);
        } finally {
            isLoading.value = false;
        }
    };

    function $reset() {
        priceHouse.value = 10000
        downPayment.value = 10
        annualInterestRate.value = 9
        deadline.value = 1
        valuePayment.value = 0
    }

    return {priceHouse, downPayment, annualInterestRate, deadline, valuePayment, $reset, fetchData, dataCalculator, isDataLoaded};
})
