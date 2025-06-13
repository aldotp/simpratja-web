import axios from "axios";

export async function getPatientExisting(medicalRecordNumber, birthDate) {
    const response = await fetch(
        `/portal/check-medical-number?medical_record_number=${encodeURIComponent(
            medicalRecordNumber
        )}&birth_date=${encodeURIComponent(birthDate)}`,
        {
            method: "GET",
        }
    );

    const data = await response.json();
    if (data.status === "success") {
        window.flasher.success(data.message);
    } else {
        window.flasher.error(data.message);
    }
    return data;
}

export async function getQueueNumber(nik, regNumber) {
    const response = await fetch(
        `/check-registration-number?nik=${encodeURIComponent(
            nik
        )}&registration_number=${encodeURIComponent(regNumber)}`,
        {
            method: "GET",
        }
    );
    const data = await response.json();
    if (data.status === "success") {
        window.flasher.success(data.message);
    } else {
        window.flasher.error(data.message);
    }
    return data;
}
