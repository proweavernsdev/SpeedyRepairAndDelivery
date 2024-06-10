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

//login
export async function loginAuth(userName, password) {
    const credentials = btoa(userName + ":" + password);
    const res = await axios.get(baseUrl + "Users", {
        headers: {
            LOGINAUTH: "Basic" + credentials,
        },
    });
    return res.data;
}

//register
export async function register(email, password, otp) {
    const res = await axios.post(baseUrl + "Users", {
        email: email,
        password: password,
        otp: otp,
    });
    return res.data;
}

//update access
export async function updateAccess(accessID) {
    const requestData = {
        update_access: true,
        update_passwordAccMgt: false,
        forgot_password: false,
        accessID: accessID,
    };

    const res = await axios.put(baseUrl + "Users", requestData, requestConfig);
    return res.data;
}

//change password
export async function changePassword(
    oldPassword,
    newPassword,
    confPassword,
    otp
) {
    const requestData = {
        update_access: false,
        update_passwordAccMgt: true,
        forgot_password: false,
        oldPassword: oldPassword,
        newPassword: newPassword,
        confPassword: confPassword,
        otp: otp,
    };
    const res = await axios.put(baseUrl + "Users", requestData, requestConfig);
    return res.data;
}

//reset password
export async function resetPassword(email, newPassword, confPassword, token) {
    if (token == null) {
        token = "";
    }
    const requestData = {
        update_access: false,
        update_passwordAccMgt: false,
        forgot_password: true,
        email: email,
        forget_password_token: token,
        newPassword: newPassword,
        confPassword: confPassword,
    };
    const res = await axios.put(baseUrl + "Users", requestData);
    return res.data;
}

//Retrieves data from the Users endpoint using axios.
export async function retrieveData() {
    updateToken();
    const res = await axios.get(baseUrl + "Users", {
        headers: {
            PWAUTH: pwauth,
        },
    });
    return res.data;
}

// Asynchronous function for uploading files
export async function uploadData(fileInputs) {
    const formData = new FormData();
    for (const fileInput of fileInputs) {
        formData.append("files[]", fileInput);
    }
    try {
        const res = await axios.post(
            "https://speedyrepairanddelivery.com/api-delivery/Api/upload",
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        );
    } catch (error) {
        console.error("Error uploading files:", error);
    }
}

// Function to handle POST request to create a booking
export async function createBooking(data) {
    updateToken();

    const requiredFields = ['SizeCategoryID', 'WeightCategoryID', 'OriginCoordinates', 'DestinationCoordinates', 'Distance', 'Notes', 'VehicleTypeID', 'Priority'];
    const emptyField = requiredFields.find(field => !data[field]);
    if (emptyField) {
        return {
            success: false,
            message: 'Input fields must not be empty',
            dataReceived: data
        };
    }

    try {
        const appFeesResponse = await axios.get(`${baseUrl}/appfees`);
        const vehicleTypesResponse = await axios.get(`${baseUrl}/deliveryvehicletype/${data.VehicleTypeID}`);
        const sizeCategoryResponse = await axios.get(`${baseUrl}/sizecategory/${data.SizeCategoryID}`);
        const weightCategoryResponse = await axios.get(`${baseUrl}/weightcategory/${data.WeightCategoryID}`);

        const appFees = appFeesResponse.data;
        const vehicleTypes = vehicleTypesResponse.data;
        const sizeCategory = sizeCategoryResponse.data;
        const weightCategory = weightCategoryResponse.data;

        let totalDistanceFee;
        if (data.Distance >= vehicleTypes.vehicle_baseDistance) {
            const excess = data.Distance - vehicleTypes.vehicle_baseDistance;
            const calculated = Math.round(excess * vehicleTypes.vehicle_distanceFee * 100) / 100;
            totalDistanceFee = (calculated + vehicleTypes.vehicle_baseFee).toFixed(2);
        } else {
            totalDistanceFee = vehicleTypes.vehicle_baseFee;
        }

        const originCoordinates = data.OriginCoordinates.split(':');
        const destinationCoordinates = data.DestinationCoordinates.split(':');

        const calculatedTotal = parseFloat(totalDistanceFee) + appFees.af_appFees + appFees.af_vat + sizeCategory.sc_setFee + weightCategory.wc_setFee;
        const total = calculatedTotal.toFixed(2);

        const bookingData = {
            bh_sizeCategory: sizeCategory.SizeCategoryID,
            bh_weightCategory: weightCategory.WeightCategoryID,
            bh_originLong: originCoordinates[0],
            bh_originLat: originCoordinates[1],
            bh_destinationLong: destinationCoordinates[0],
            bh_destinationLat: destinationCoordinates[1],
            bh_distance: data.Distance,
            bh_distanceFee: totalDistanceFee,
            bh_notes: data.Notes,
            bh_user_initiator: decrypted.UserID,
            bh_vehicleType: vehicleTypes.vehicleTypeID,
            bh_appFees: appFees.af_appFees,
            bh_vat: appFees.af_vat,
            bh_total: total,
        };

        if (decrypted.UserAccess === 5) {
            const employeeResponse = await axios.get(`${baseUrl}/subusers/${decrypted.UserID}`);
            const employee = employeeResponse.data;
            bookingData.bh_company_order = employee.subs_underCompany;
        }

        const insertResponse = await axios.post(`${baseUrl}/bookinghistory`, bookingData);
        if (insertResponse.data.success) {
            const prioResponse = await axios.get(`${baseUrl}/prioritylist/${data.Priority}`);
            const prio = prioResponse.data;

            const toFirebase = {
                [insertResponse.data.id]: {
                    Points: prio,
                    Coordinates: {
                        long: originCoordinates[0],
                        lat: originCoordinates[1]
                    },
                    Status: 'In-Pool'
                }
            };

            const firebaseResponse = await axios.post(`${baseUrl}/speedydelivery/pool`, toFirebase);
            if (firebaseResponse.data.success) {
                return {
                    success: true,
                    message: 'Successfully inserted data'
                };
            } else {
                return {
                    success: false,
                    message: 'Data insertion unsuccessful'
                };
            }
        } else {
            return {
                success: false,
                message: 'Internal Server Error'
            };
        }
    } catch (error) {
        console.error("Error: " + error);
        return {
            success: false,
            message: 'Internal Server Error'
        };
    }
};