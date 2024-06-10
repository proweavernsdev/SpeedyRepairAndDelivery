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

//Creates a driver with the given information and documents.
export async function createDriver(firstName, lastName, addr, townCity, state, zip, licenseNumber, vehicleType, docs) {
    updateToken();
    const formData = new FormData();

    // Append company data
    formData.append("FirstName", firstName);
    formData.append("LastName", lastName);
    formData.append("Address", addr);
    formData.append("TownCity", townCity);
    formData.append("State", state);
    formData.append("Zip", zip);
    formData.append("LicenseNumber", licenseNumber);
    formData.append("VehicleType", vehicleType);

    // Append files
    for (const doc of docs) {
        formData.append("files[]", doc);
    }

    try {
        const response = await axios.post(baseUrl + "DeliveryDrivers", formData, {
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

//Retrieves data from the DeliveryDrivers API endpoint.
export async function driverRetrieveData() {
    updateToken();
    const res = await axios.get(baseUrl + "DeliveryDrivers", {
        headers: {
            PWAUTH: pwauth,
        },
    }).catch((err) => {
        console.error("Error: " + err);
    });
    return res.data;
}

//Updates the driver status in the system.
export async function setDriverStatus(driverID, status) {
    updateToken();
    const requestData = {
        DriverID: driverID,
        Status: status,
    };
    await axios.put(baseUrl + "DeliveryDrivers", requestData, requestConfig)
        .then((res) => {
            return res.data;
        })
        .catch((err) => {
            console.error(err);
            return err.data;
        });
}

//Asynchronous function for setting a driver profile picture.
export async function driverSetPfp(fileInputs) {
    updateToken();
    const formData = new FormData();
    formData.append("file", fileInputs);
    try {
        const res = await axios.post(baseUrl + "DeliveryDrivers/upload", formData, {
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

//Updates the driver in the system.
export async function updateDriver(firstName, lastName, addr, townCity, state, zip, licenseNumber, vehicleType) {
    updateToken();
    const updatedDriverData = {
        FirstName: firstName,
        LastName: lastName,
        Address: addr,
        TownCity: townCity,
        State: state,
        Zip: zip,
        LicenseNumber: licenseNumber,
        VehicleType: vehicleType,
    };
    try {
        const response = await axios.put(baseUrl + "DeliveryDrivers", updatedDriverData, {
            headers: {
                "Content-Type": "multipart/form-data",
                PWAUTH: pwauth,
            },
        }
        );
        return response.data;
    } catch (error) {
        console.error("Error creating company:", error);
        throw error;
    }
}