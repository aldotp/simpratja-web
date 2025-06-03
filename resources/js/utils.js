// Import flasher correctly - it doesn't have a default export
import * as flasherModule from "../../public/vendor/flasher/flasher-toastr.min.js";

// Get the flasher object from the module
const flasher = window.flasher || flasherModule;

export async function getPatientExisting(medicalRecordNumber, birthDate) {
    const response = await fetch(
        `/portal/check-medical-number?medical_record_number=${encodeURIComponent(
            medicalRecordNumber
        )}&birth_date=${encodeURIComponent(birthDate)}`
    );
    const data = await response.json();
    if (data.status === "success") {
        flasher.success(data.message);
    } else {
        flasher.error(data.message);
    }
    return data;
}

export async function getQueueNumber(nik, regNumber) {
    const response = await fetch(
        `/check-registration-number?nik=${encodeURIComponent(
            nik
        )}&registration_number=${encodeURIComponent(regNumber)}`
    );
    const data = await response.json();
    if (data.status === "success") {
        flasher.success(data.message);
    } else {
        flasher.error(data.message);
    }
    return data;
}
