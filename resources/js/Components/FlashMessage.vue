<script setup>
import { usePage } from "@inertiajs/vue3";
import { toast } from 'vue3-toastify';

const notify = (message, type, transition) => {
    toast(message, {
        "theme": "colored",
        "transition": transition,
        "autoClose": 2000,
        "type": type,
    });
}

const success = usePage().props.flash.success;
const error = usePage().props.flash.error;
const warning = usePage().props.flash.warning;

if (success) {
    notify(success, 'success', 'slide');
}
else if (error) {
    notify(error, 'error', 'bounce');
}
else if (warning) {
    notify(warning, 'warning', 'zoom');
}

</script>