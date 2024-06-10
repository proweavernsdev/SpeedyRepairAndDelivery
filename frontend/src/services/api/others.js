import axios from "axios";

const baseUrl = "https://speedyrepairanddelivery.com/api-delivery/";

let pwauth = JSON.parse(localStorage.getItem("token"));
const requestConfig = {
    headers: {
        PWAUTH: pwauth,
    },
};

let updateToken = () => {
    pwauth = JSON.parse(localStorage.getItem("token"));
};

//Get all data for Taxonomies Page
export async function getTaxonomies() {
    updateToken();
    const res = await axios
        .get(baseUrl + "TaxonomyHub", {
            headers: {
                PWAUTH: pwauth,
            },
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
    return res;
}

//Adds a new size to the Taxonomies Page.
export async function addSize(categoryName, min, max, setFee) {
    updateToken();
    let setSize = {
        Category: categoryName,
        Min: min,
        Max: max,
        SetFee: setFee,
    };
    try {
        const res = await axios.post(
            baseUrl + "TaxonomyHub/size",
            setSize,
            requestConfig
        );
        console.log("Successfully added the size");
        return res;
    } catch (err) {
        console.error("Size was not added");
    }
}

//Adds a new weight to the Taxonomies Page.
export async function addWeight(categoryName, min, max, setFee) {
    updateToken();
    let setWeight = {
        Category: categoryName,
        Min: min,
        Max: max,
        SetFee: setFee,
    };
    try {
        const res = await axios.post(
            baseUrl + "TaxonomyHub/weight",
            setWeight,
            requestConfig
        );
        console.log("Successfully added the weight");
        return res;
    } catch (err) {
        console.error("Weight was not added");
    }
}

//Updates the data on the Taxonomies Page.
export async function updateData(data) {
    updateToken();
    await axios
        .put(baseUrl + "TaxonomyHub", data, {
            headers: {
                PWAUTH: pwauth,
            },
        })
        .then((res) => {
            return res;
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
}

//Updates the size data on the Taxonomies Page.
export async function updateSize(id, categoryName, min, max, setFee) {
    updateToken();
    let updateSizes = {
        ID: id,
        Category: categoryName,
        Min: min,
        Max: max,
        SetFee: setFee,
    };
    console.log(updateSizes);
    try {
        const res = await axios.put(
            baseUrl + "TaxonomyHub/size",
            updateSizes,
            requestConfig
        );
        console.log("Successfully updated the size");
        return res;
    } catch (err) {
        console.error("Weight was not updated");
    }
}

//Deletes the size data on the Taxonomies Size Page.
export async function deleteSize(id) {
    updateToken();
    await axios
        .delete(baseUrl + "TaxonomyHub/size/", {
            headers: {
                PWAUTH: pwauth,
                DELID: id,
            },
        })
        .then((res) => {
            return res;
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
}

//Updates the weight data on the Taxonomies Page.
export async function updateWeight(id, categoryName, min, max, setFee) {
    updateToken();
    let updateWeights = {
        ID: id,
        Category: categoryName,
        Min: min,
        Max: max,
        SetFee: setFee,
    };
    console.log(updateWeights);
    try {
        const res = await axios.put(
            baseUrl + "TaxonomyHub/weight",
            updateWeights,
            requestConfig
        );
        console.log("Successfully updated the weight");
        return res;
    } catch (err) {
        console.error("Weight was not updated");
    }
}

export async function deleteWeight(id) {
    updateToken();
    await axios
        .delete(baseUrl + "TaxonomyHub/weight/", {
            headers: {
                PWAUTH: pwauth,
                DELID: id,
            },
        })
        .then((res) => {
            return res;
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
}

//Get all data for Fees Page
export async function getFees() {
    updateToken();
    const res = await axios
        .get(baseUrl + "App", {
            headers: {
                PWAUTH: pwauth,
            },
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
    return res;
}

//Updates the data on the Fees Page.
export async function updateFees(data) {
    updateToken();
    const res = await axios
        .put(baseUrl + "App", data, {
            headers: {
                PWAUTH: pwauth,
            },
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
    return res;
}

//Get all data for Vehicles Page
export async function getVehicles() {
    updateToken();
    const res = await axios
        .get(baseUrl + "Vehicles", {
            headers: {
                PWAUTH: pwauth,
            },
        })
        .catch((err) => {
            console.error("Error: " + err);
        });
    return res;
}