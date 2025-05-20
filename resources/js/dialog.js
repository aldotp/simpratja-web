import { Modal } from "flowbite";

/**
 * DialogManager: Mengelola modal dan toast secara global (Flowbite + fallback).
 */
class DialogManager {
    /**
     * Tampilkan modal Flowbite dengan ID tertentu.
     * @param {string} modalId  ID elemen modal.
     * @param {Object} [options] Opsi Flowbite Modal (placement, dll).
     */
    static showModal(modalId, options = {}) {
        const modalEl = document.getElementById(modalId);
        if (!modalEl) {
            console.warn(
                `DialogManager: Modal dengan ID "${modalId}" tidak ditemukan.`
            );
            return;
        }
        // Jika Flowbite Modal tersedia, gunakan API-nya.
        if (typeof Modal !== "undefined") {
            const modal = new Modal(modalEl, options);
            modal.show();
        } else {
            // Fallback sederhana: hilangkan kelas 'hidden' untuk menampilkan
            modalEl.classList.remove("hidden");
            modalEl.classList.add("flex");
        }
    }

    /**
     * Sembunyikan modal dengan ID tertentu.
     * @param {string} modalId  ID elemen modal.
     */
    static closeModal(modalId) {
        const modalEl = document.getElementById(modalId);
        if (!modalEl) return;
        if (typeof Modal !== "undefined") {
            const modal = new Modal(modalEl, {});
            modal.hide();
        } else {
            // Fallback: tambahkan kembali 'hidden'
            modalEl.classList.add("hidden");
            modalEl.classList.remove("flex");
        }
    }
}

// Ekspos ke global supaya bisa dipanggil dari Blade
window.DialogManager = DialogManager;
