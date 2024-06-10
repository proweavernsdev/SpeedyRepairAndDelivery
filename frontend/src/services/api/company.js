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

// Get all as Company User
export async function getCompDocs() {
    updateToken();
    await axios.get(baseUrl + "Company/docs", {
        header: {
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

// Get all as Driver User
export async function getDriverDocs() {
    updateToken();
    await axios
        .get(baseUrl + "Company/docs", {
            header: {
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

//Creates a company with the given information and documents.
export async function createCompany(
    compName,
    compAddr,
    townCity,
    compState,
    compZip,
    docs
) {
    updateToken();
    const formData = new FormData();

    // Append company data
    formData.append("CompName", compName);
    formData.append("CompAddr", compAddr);
    formData.append("TownCity", townCity);
    formData.append("CompState", compState);
    formData.append("CompZip", compZip);

    // Append files
    for (const doc of docs) {
        formData.append("files[]", doc);
    }

    try {
        const response = await axios.post(baseUrl + "Company", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
                PWAUTH: pwauth,
            },
        });
        //console.log('Upload successful:', response.data);
        return response.data;
    } catch (error) {
        console.error("Error creating company:", error);
        throw error;
    }
}

//Retrieves data from the Company API endpoint.
export async function compRetrieveData() {
    updateToken();
    const res = await axios.get(baseUrl + "Company", {
        headers: {
            PWAUTH: pwauth,
        },
    }).catch((err) => {
        console.error("Error: " + err);
    });
    return res.data;
}

//Sets the status of a company.
export async function setCompStatus(companyID, status) {
    updateToken();
    const requestData = {
        CompanyID: companyID,
        Status: status,
    };
    await axios
        .put(baseUrl + "Company", requestData, requestConfig)
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            console.error(err);
            return err.data;
        });
}

//Asynchronous function for setting a company profile picture.
export async function uploadProfilePicture(fileInputs) {
    updateToken();
    const formData = new FormData();
    formData.append("file", fileInputs);
    try {
        const res = await axios.post(baseUrl + "Company/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
                PWAUTH: pwauth,
            },
        });
        console.log("Upload successful:", res.data);
    } catch (error) {
        console.error("Error uploading files:", error);
    }
}

export async function updateStatus(pwauth, data) {
    try {
        const res = await axios.put(baseUrl + "Company", data, {
            headers: {
                'Content-Type': 'application/json',
                PWAUTH: pwauth,
            },
        });
        return res.data;
    } catch (err) {
        console.error("Error: " + err);
        throw err;
    }
}

export async function getPfp(pwauth) {
    try {
        const res = await axios.get(baseUrl + "Company/pfp", {
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

export async function uploadPfp(pwauth, file) {
    try {
        const formData = new FormData();
        formData.append('file', file);

        const res = await axios.post(baseUrl + "Company/pfp", formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                PWAUTH: pwauth,
            },
        });
        return res.data;
    } catch (err) {
        console.error("Error: " + err);
        throw err;
    }
}

export async function updateCompanyDetails(pwauth, data) {
    try {
        const res = await axios.put(baseUrl + "Company/update", data, {
            headers: {
                'Content-Type': 'application/json',
                PWAUTH: pwauth,
            },
        });
        return res.data;
    } catch (err) {
        console.error("Error: " + err);
        throw err;
    }
}