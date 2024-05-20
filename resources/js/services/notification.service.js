import { ElNotification } from 'element-plus'

export function Notify(type, message, title = 'Mensaje') {

    setTimeout(() => {

        ElNotification({
            type: type,
            title: title,
            message: message,
            position: 'top-right',
            duration: 2000
        });

    }, 1000);
}
