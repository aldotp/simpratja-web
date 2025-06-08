import axios from "axios";
import * as flasherModule from "../../public/vendor/flasher/flasher-toastr.min.js";

const flasher = window.flasher || flasherModule;

export async function getPatientExisting(medicalRecordNumber, birthDate) {
    const response = await axios.get(
        `/portal/check-medical-number?medical_record_number=${encodeURIComponent(
            medicalRecordNumber
        )}&birth_date=${encodeURIComponent(birthDate)}`
    );

    const data = response.data;
    if (data.status === "success") {
        flasher.success(data.message);
    } else {
        flasher.error(data.message);
    }
    return data;
}

export async function getQueueNumber(nik, regNumber) {
    const response = await axios.get(
        `/check-registration-number?nik=${encodeURIComponent(
            nik
        )}&registration_number=${encodeURIComponent(regNumber)}`
    );
    const data = response.data;
    if (data.status === "success") {
        flasher.success(data.message);
    } else {
        flasher.error(data.message);
    }
    return data;
}
