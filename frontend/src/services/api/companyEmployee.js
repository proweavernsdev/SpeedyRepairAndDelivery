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

// Create sub-users for company accounts
export async function employeeRegistration(
    email,
    password,
    firstName,
    lastName
) {
    updateToken();
    await axios
        .post(
            baseUrl + "Company/employee",
            {
                email: email,
                password: password,
                FirstName: firstName,
                LastName: lastName,
            },
            {
                headers: {
                    PWAUTH: pwauth,
                },
            }
        )
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            console.error(err);
        });
}

// Get all Company User
export async function retrieveEmployee() {
    updateToken();
    try {
        const res = await axios.get(baseUrl + "Company/employee", {
            headers: {
                PWAUTH: pwauth,
            },
        });
        return res.data;
    } catch (error) {
        console.error("Error fetching data:", error);
        throw error;
    }
}

// Set employee status
export async function setEmployeeStatus(sub_userID, status) {
    updateToken();
    const requestData = {
        CompanyID: sub_userID,
        Status: status,
    };
    await axios
        .put(baseUrl + "Company/employee", requestData, requestConfig)
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            console.error(err);
            return err.data;
        });
}

//Asynchronous function for setting a employee profile picture.
export async function setEmployeePfp(fileInputs) {
    updateToken();
    const formData = new FormData();
    formData.append("file", fileInputs);
    try {
        const res = await axios.post(baseUrl + "Company/employee/pfp", formData, {
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

//Asynchronous function for creating an employee.
export async function createEmployee(pwauth, postData) {
    try {
        const res = await axios.post(baseUrl + "Company/employee", postData, {
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

//Asynchronous function for updating an employee.
export async function updateEmployee(pwauth, data) {
    try {
        const res = await axios.put(baseUrl + "Company/employee", data, {
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