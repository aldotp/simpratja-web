import { Modal } from "flowbite";

// Function to show feedback modal
function showFeedbackModal() {
    // Get patient data from localStorage
    const patientData = JSON.parse(localStorage.getItem("currentPatientData"));

    // Check if feedback has already been given for this visit
    const feedbackGiven =
        patientData && patientData.visit_id
            ? localStorage.getItem(`feedback_given_${patientData.visit_id}`) ===
              "true"
            : false;

    if (patientData && !feedbackGiven) {
        // Set patient ID in the hidden input
        document.getElementById("patient_id").value = patientData.patient_id;

        // Initialize the modal with static backdrop
        const feedbackModalElement = document.getElementById("feedback-modal");
        const feedbackModal = new Modal(feedbackModalElement, {
            backdrop: "static",
            placement: "center",
        });

        // Show feedback modal
        feedbackModal.show();
        
        // Add event listener to all elements with data-modal-hide attribute for this modal
        document.querySelectorAll(`[data-modal-hide="feedback-modal"]`).forEach(element => {
            element.addEventListener('click', () => {
                closeModal(feedbackModal);
            });
        });
        
        // Add event listener to the form submission
        const feedbackForm = document.getElementById('feedback-form');
        if (feedbackForm) {
            feedbackForm.addEventListener('submit', () => {
                // Close modal after form submission
                setTimeout(() => closeModal(feedbackModal), 100);
            });
        }
    }
}

// Function to close modal and remove backdrop
function closeModal(modal) {
    // Hide the modal
    modal.hide();
    
    // Remove the backdrop element
    setTimeout(() => {
        const backdropElement = document.querySelector("body > div[modal-backdrop]");
        if (backdropElement) {
            backdropElement.remove();
        }
    }, 100);
}

export { showFeedbackModal };
