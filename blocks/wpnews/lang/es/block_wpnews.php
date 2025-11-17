<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Spanish language strings for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Noticias WordPress';
$string['wpnews'] = 'Noticias WordPress';

// Capabilities.
$string['wpnews:addinstance'] = 'Añadir un nuevo bloque de Noticias WordPress';
$string['wpnews:myaddinstance'] = 'Añadir un nuevo bloque de Noticias WordPress a Mi Moodle';
$string['wpnews:viewcontent'] = 'Ver contenido de Noticias WordPress';

// Block configuration.
$string['blocktitle'] = 'Título del bloque';
$string['blocktitle_help'] = 'Título personalizado para este bloque. Dejar vacío para usar el título predeterminado.';
$string['defaulttitle'] = 'Noticias WordPress';

// WordPress connection.
$string['wpurl'] = 'URL de WordPress';
$string['wpurl_help'] = 'La URL completa de su sitio WordPress (ej: https://ejemplo.com)';
$string['postcount'] = 'Número de entradas';
$string['postcount_help'] = 'Cuántas entradas mostrar (1-20)';

// Display options.
$string['displayoptions'] = 'Opciones de visualización';
$string['layout'] = 'Diseño';
$string['layout_help'] = 'Elegir entre diseño de lista o cuadrícula para mostrar las entradas';
$string['layoutlist'] = 'Lista';
$string['layoutgrid'] = 'Cuadrícula';

$string['showimage'] = 'Mostrar imagen destacada';
$string['showimage_help'] = 'Mostrar la imagen destacada de cada entrada';
$string['imagesize'] = 'Tamaño de imagen';
$string['imagesize_help'] = 'Seleccionar el tamaño de las imágenes destacadas';
$string['sizethumbnail'] = 'Miniatura';
$string['sizemedium'] = 'Mediano';
$string['sizelarge'] = 'Grande';
$string['sizefull'] = 'Tamaño completo';

$string['showexcerpt'] = 'Mostrar extracto';
$string['showexcerpt_help'] = 'Mostrar el extracto de la entrada';
$string['showdate'] = 'Mostrar fecha';
$string['showdate_help'] = 'Mostrar la fecha de publicación';
$string['dateformat'] = 'Formato de fecha';
$string['dateformat_help'] = 'Cadena de formato de fecha PHP (ej: "j \\d\\e F \\d\\e Y" para "1 de enero de 2024")';
$string['showcategories'] = 'Mostrar categorías';
$string['showcategories_help'] = 'Mostrar las categorías de la entrada como etiquetas';

// Authentication.
$string['authentication'] = 'Autenticación';
$string['username'] = 'Nombre de usuario';
$string['username_help'] = 'Nombre de usuario de WordPress (opcional, para sitios privados)';
$string['password'] = 'Contraseña';
$string['password_help'] = 'Contraseña de aplicación de WordPress (opcional, para sitios privados)';

// Cache options.
$string['cacheoptions'] = 'Opciones de caché';
$string['cachetime'] = 'Duración de caché (minutos)';
$string['cachetime_help'] = 'Cuánto tiempo almacenar en caché las entradas de WordPress antes de obtener nuevos datos';

// Global settings.
$string['plugininfo'] = 'Información del plugin';
$string['plugininfodesc'] = 'Este bloque muestra noticias de un sitio WordPress usando la API REST de WordPress v2.';
$string['defaultcachetime'] = 'Tiempo de caché predeterminado';
$string['defaultcachetime_desc'] = 'Duración de caché predeterminada en minutos para nuevas instancias del bloque';
$string['defaultpostcount'] = 'Número de entradas predeterminado';
$string['defaultpostcount_desc'] = 'Número predeterminado de entradas a mostrar para nuevas instancias del bloque';
$string['defaultlayout'] = 'Diseño predeterminado';
$string['defaultlayout_desc'] = 'Estilo de diseño predeterminado para nuevas instancias del bloque';
$string['timeout'] = 'Tiempo de espera de conexión';
$string['timeout_desc'] = 'Tiempo de espera de solicitud HTTP en segundos';
$string['debug'] = 'Habilitar depuración';
$string['debug_desc'] = 'Registrar información de error detallada para solución de problemas';
$string['cachemanagement'] = 'Gestión de caché';
$string['cachemanagement_desc'] = 'Administrar datos de WordPress en caché';
$string['purgecacheinfo'] = 'Para borrar todas las entradas de WordPress en caché, use la página {$a}.';

// Messages.
$string['readmore'] = 'Leer más';
$string['noposts'] = 'No se encontraron entradas';
$string['nowpurl'] = 'Por favor configure la URL de WordPress en la configuración del bloque';
$string['error'] = 'Error al cargar las entradas de WordPress';

// Validation errors.
$string['invalidurl'] = 'URL de WordPress inválida';
$string['invalidcachetime'] = 'El tiempo de caché debe ser un número positivo';
$string['numeric'] = 'Debe ser un número';
$string['connectionfailed'] = 'No se pudo conectar a WordPress';

// API errors.
$string['invalidwpurl'] = 'URL de WordPress inválida: {$a}';
$string['curliniterror'] = 'No se pudo inicializar cURL';
$string['curlerror'] = 'Error de cURL: {$a}';
$string['authenticationfailed'] = 'Autenticación fallida. Verifique su nombre de usuario y contraseña.';
$string['accessforbidden'] = 'Acceso prohibido. El sitio WordPress puede ser privado.';
$string['endpointnotfound'] = 'No se encontró el endpoint de la API REST de WordPress en {$a}. Asegúrese de que la API REST esté habilitada.';
$string['servererror'] = 'Error del servidor de WordPress (HTTP {$a})';
$string['httperror'] = 'Error HTTP {$a}';
$string['jsonparseerror'] = 'No se pudo analizar la respuesta de WordPress: {$a}';
$string['invalidresponse'] = 'Respuesta inválida de la API de WordPress';

// Privacy.
$string['privacy:metadata'] = 'El bloque de Noticias WordPress solo muestra datos de sitios WordPress externos y no almacena ningún dato personal.';
