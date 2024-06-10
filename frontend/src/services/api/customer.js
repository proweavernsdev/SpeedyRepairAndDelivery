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

//Create a new customer with the given parameters to the database.
export async function createCustomer(pwauth, postData) {
    try {
        const res = await axios.post(baseUrl + "Customer", postData, {
            headers: {
                PWAUTH: pwauth,
            },
        });
        return res.data;
    } catch (err) {
        console.error("Error: " + err);
        throw err;
    }
}

//Retrieves data from the Customer API endpoint.
export async function userRetrieveData(pwauth) {
    try {
        const res = await axios.get(baseUrl + "Customer/user", {
            headers: {
                PWAUTH: pwauth,
            },
        });
        return res.data;
    } catch (err) {
        console.error("Error: " + err);
        throw err;
    }
}

