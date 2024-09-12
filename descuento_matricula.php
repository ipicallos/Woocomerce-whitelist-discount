<?php
function obtener_emails_desde_csv($ruta_csv)
{
    $emails = [];

    if (($gestor = fopen($ruta_csv, 'r')) !== FALSE)
    {
        // Leer la primera línea (encabezado)
        fgetcsv($gestor);

        // Leer el resto de las líneas
        while (($datos = fgetcsv($gestor)) !== FALSE)
        {
            if (!empty($datos[0]))
            {
                // Sanitiza el correo electrónico
                $email_sanitizado = filter_var($datos[0], FILTER_SANITIZE_EMAIL);
                // Valida el correo electrónico
                if (filter_var($email_sanitizado, FILTER_VALIDATE_EMAIL))
                {
                    $emails[] = $email_sanitizado;
                }
            }
        }
        fclose($gestor);
    }

    return $emails;
}

add_action('woocommerce_cart_calculate_fees', 'descuento_cuota_alta_por_csv');

function descuento_cuota_alta_por_csv()
{
    if (is_user_logged_in())
    {
        $user = wp_get_current_user();
        $email_usuario = $user->user_email;

        // Sanitizar y validar el correo electrónico del usuario
        $email_usuario_sanitizado = filter_var($email_usuario, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email_usuario_sanitizado, FILTER_VALIDATE_EMAIL))
        {
            return; // Si no es un correo electrónico válido, salir de la función
        }

        // Ruta al archivo CSV
        $ruta_csv = get_template_directory() . '/usuarios_activos/usuarios.csv';

        if (file_exists($ruta_csv))
        {
            $usuarios_con_descuento = obtener_emails_desde_csv($ruta_csv);

            // Verificar si el usuario está en la lista del CSV
            if (in_array($email_usuario_sanitizado, $usuarios_con_descuento))
            {
                $nombre_cuota = 'Sign-up Fee'; // Nombre de la cuota de alta (ajustar si es necesario)
                $descuento = 100; // Descuento del 100%

                // Recorre las cuotas del carrito para encontrar la cuota de alta
                foreach (WC()->cart->get_fees() as $key => $fee)
                {
                    if ($fee->name === $nombre_cuota)
                    {
                        // Elimina la cuota original
                        WC()->cart->remove_fee($key);

                        // Añade la cuota con descuento del 100%
                        WC()->cart->add_fee(__('Sign-up Fee with Discount', 'woocommerce'), 0, true);
                        break; // Salir del bucle una vez que la cuota haya sido encontrada y procesada
                    }
                }
            }
            // Si el usuario no está en la lista, no se aplica ningún descuento y la cuota de alta original se mantiene
        }
    }
}
?>
