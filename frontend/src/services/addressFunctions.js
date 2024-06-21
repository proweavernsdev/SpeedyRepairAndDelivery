import { ref } from 'vue';

const searchQuery = ref('');
const searchResults = ref([]);

const searchLocation = async (query) => {
    if (query.length < 3) return;

    const accessToken = 'pk.eyJ1Ijoiam9obi0yMDAxIiwiYSI6ImNsdm1yaXRxNDA2NHgyanBlY2oxanFja3gifQ.W_pQHATCMu0KrjHWAHF-CA';
    const response = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${accessToken}`);
    const data = await response.json();

    searchResults.value = data.features.map(feature => ({
        place_name: feature.place_name,
        center: feature.center
    }));
};

const validateAddress = (form) => {
    const { address } = form;
    const errors = {};

    if (!address || !address.value) {
        errors.address = 'Address is required.';
    }

    if (Object.keys(errors).length > 0) {
        return { isValid: false, errors };
    }

    return { isValid: true, errors: {} };
};

export {
    searchQuery,
    searchResults,
    searchLocation,
    validateAddress
};
