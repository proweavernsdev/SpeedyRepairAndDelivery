import { ref } from 'vue';

const isOpen = ref(false);

const closeModal = () => {
    isOpen.value = !isOpen.value;
    console.log("IsOpen value: " + isOpen.value);
};

const confirmBooking = () => {
    router.push('delivery/confirmation');
};

export {
    isOpen,
    closeModal,
    confirmBooking
};
