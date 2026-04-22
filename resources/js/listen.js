import './bootstrap';
import Swal from 'sweetalert2';

window.Echo.channel('sport-channel')
    .listen('MessageEvent', (data) => {
        console.log("Ma'lumot keldi:", data);

        let name = data.athlete.first_name || data.athlete;

        Swal.fire({
            title: 'Reyting yangilandi!',
            text: "Sportchi: " + name,
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    });
