import { ref } from 'vue';

const sizeCategory = ref("");
const sizeMeasurements = ref("");

const updateSizeForm = () => {
    const volumeCubicFeet = convertToCubicFeet(length, sizeDropdown) *
        convertToCubicFeet(width, sizeDropdown) *
        convertToCubicFeet(height, sizeDropdown);
    sizeMeasurements.value = `(${length.value} ${sizeDropdown.value.toLowerCase()} ✖ ` +
        `${width.value} ${sizeDropdown.value.toLowerCase()} ✖ ` +
        `${height.value} ${sizeDropdown.value.toLowerCase()})`;

    sizeCategory.value = volumeCubicFeet <= 1 ? "Small" : volumeCubicFeet <= 5 ? "Medium" : "Large";
};

const convertToCubicFeet = (value, unit) => {
    const num = parseFloat(value.value);
    switch (unit.value) {
        case "Feet": return num;
        case "Inches": return num / 12;
        case "Meters": return num * 35.3147;
        case "Centimeters": return num / 30.48;
        default: return 0;
    }
};

const weightCategory = ref("");
const weightMeasurements = ref("");

const updateWeightForm = () => {
    const weightKg = convertToKilograms(weight, weightDropdown);
    weightMeasurements.value = `(${weight.value} ${weightDropdown.value.toLowerCase()})`;
    weightCategory.value = weightKg <= 1 ? "Light" : weightKg <= 5 ? "Moderate" : "Heavy";
};

const convertToKilograms = (value, unit) => {
    const num = parseFloat(value.value);
    switch (unit.value) {
        case "Kg": return num;
        case "g": return num / 1000;
        case "lb": return num * 0.453592;
        case "oz": return num * 0.0283495;
        default: return 0;
    }
};

export {
    sizeCategory,
    sizeMeasurements,
    updateSizeForm,
    weightCategory,
    weightMeasurements,
    updateWeightForm
};
