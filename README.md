# Documentación del Proyecto: Pecera Digital

**Alumno:** Víctor Agüera Cordero **Módulo:** Desarrollo de Aplicaciones Web

## 1. Guía de Instalación y Configuración (Entorno Local)

Con el fin de lograr una instalación sencilla y rápida, el proyecto web ha sido desarrollado haciendo uso de Docker. De este modo, el despliegue de la página constituye el único paso necesario para su correcto funcionamiento.

**Requisitos previos:**

* Tener instalado Docker Desktop o Docker Engine y Docker Compose.

**Pasos para el despliegue:**

1. Descomprimir el archivo .zip que contiene el proyecto.
2. Abrir un terminal o línea de comandos y navegar hasta el directorio raíz del proyecto (donde se encuentra el archivo docker-compose.yml).
3. Ejecutar el siguiente comando para construir y levantar los contenedores en segundo plano:
   docker-compose up -d
4. El sistema levantará automáticamente tres servicios:
   * **Servidor Web (Apache + PHP):** Servirá la aplicación web.
   * **Base de Datos (MySQL):** Se auto-poblará con la estructura de tablas y datos iniciales gracias al archivo init.sql ubicado en la carpeta /db mapeada en el volumen.
   * **phpMyAdmin:** Interfaz web para gestionar la base de datos (opcional).

**Acceso a la aplicación:**

* **Pecera Digital:** Abrir un navegador web y acceder a http://localhost:8080.
* **phpMyAdmin (Gestión BD):** Accesible en http://localhost:8081.

## 2. Credenciales de Acceso

El sistema requiere autenticación. Las contraseñas están encriptadas de forma segura en la base de datos mediante la función password\_hash() (algoritmo BCRYPT) de PHP.

Para facilitar la corrección, se ha incluido un usuario administrador de prueba en el archivo de inicialización SQL:

* **Usuario:** admin
* **Contraseña:** admin
  
La cuenta administrador se ha configurado para tener dinero casi ilimitado (9999) y niveles maximizados (100), para facilitar la revisión de la compra del usuario.

*(Nota: El sistema incluye una página de registro funcional en la pantalla de inicio de sesión, por lo que el equipo evaluador también puede crear una nueva cuenta si lo desea).*

## 3. Aspectos de Especial Interés

La implementación del proyecto va más allá de un simple CRUD, integrando mecánicas de gamificación y tecnologías variadas:

* **Sistema de Ayuda Integrado:** Se ha implementado un sistema de ayuda en línea nativo, accesible desde el menú de Configuración mediante el botón "❓ Cómo jugar / Ayuda", facilitando la curva de aprendizaje al usuario.
* **Generación de Informes Dinámicos:** La aplicación permite exportar un informe detallado de las estadísticas del usuario (Nivel, Dinero, e Inventario de objetos). Se ha logrado manipulando las cabeceras HTTP (header()) en PHP para forzar la descarga de un archivo de texto plano (.txt) generado al vuelo a partir de múltiples consultas a la base de datos.
* **Integración de API Externa (Open-Meteo):** Se consume una API REST externa utilizando JavaScript asíncrono (fetch) para obtener y mostrar la temperatura meteorológica real (configurada actualmente para las coordenadas de Algeciras) en el panel de control de la pecera.
* **Gestión de Estado Híbrida:** El juego mantiene el estado temporal de la economía (XP, dinero) en el cliente mediante JavaScript y sincroniza los datos persistentes de forma asíncrona con el servidor mediante peticiones AJAX (API Fetch) a scripts PHP, logrando una experiencia fluida sin recargas de página completas.
* **Arquitectura Desacoplada (Backend/Frontend):** Uso claro de la separación de responsabilidades. El frontend (HTML/CSS/JS) se encarga de la interfaz y la lógica de juego, mientras que scripts PHP dedicados (guardar\_stats.php, obtener\_stats.php, cargar\_peces.php, etc.) actúan como una rudimentaria API RESTful para el acceso a datos.

## 4. Problemas Encontrados y Soluciones Aplicadas

Durante la fase de desarrollo, surgieron varios retos técnicos significativos:

1. **Problemas de Caché Agresiva en CSS/JS:**
   * *Problema:* Al actualizar la hoja de estilos (styles.css), como la implementación de la cuadrícula de fondos (CSS Grid), los cambios no se reflejaban en el navegador debido a la caché, dificultando el desarrollo de la interfaz visual.
   * *Solución:* Se implementó *cache busting* añadiendo un parámetro dinámico con el *timestamp* actual en la etiqueta link de PHP (<link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">). Esto fuerza al navegador a solicitar siempre la versión más reciente del archivo.
2. **Choque de Contextos de Apilamiento (Z-Index y Modales):**
   * *Problema:* La interfaz se volvía caótica al abrir varias tiendas simultáneamente (Peces, Corales, Decoraciones), ya que las ventanas se superponían de forma inconsistente.
   * *Solución:* Se refactorizó la lógica de navegación en JavaScript centralizándola en una función cambiarPantalla. Esta función se encarga de aplicar display: none a todas las secciones secundarias antes de mostrar la activa, garantizando que solo una ventana modal esté visible a la vez.
3. **Restricciones de Autoplay de Audio en Navegadores Modernos:**
   * *Problema:* El sonido ambiental y la música no se reproducen automáticamente al cargar la página, arrojando errores DOMException en consola debido a las estrictas políticas de *autoplay* de los navegadores (Chrome, Firefox).
   * *Solución:* Se diseñó un sistema híbrido. Se intenta la reproducción silenciosa inicial (capturando la promesa con .catch() para evitar errores en consola). Simultáneamente, se añade un *Event Listener* al body con la opción { once: true } para que la reproducción se inicie inmediatamente tras la primera interacción consciente del usuario (un clic).
4. **Incompatibilidad de Credenciales tras Encriptación:**
   * *Problema:* Al implementar el requisito de seguridad para el hash de contraseñas (password\_hash()), el usuario "admin" creado manualmente en la base de datos previa con texto plano dejó de funcionar durante el proceso de validación (password\_verify()).
   * *Solución:* Se implementó el archivo registro.php para gestionar la creación de usuarios de forma segura. Se purgó el usuario de prueba obsoleto y se regeneró a través del nuevo flujo de registro para asegurar que el hash almacenado fuera el correcto.

## 5. Funciones No Implementadas y Mejoras Futuras

Debido a los límites de tiempo del proyecto y al enfoque en la estabilidad de las mecánicas principales, algunas ideas se aplazaron para iteraciones posteriores:

* **Sistema de Vitalidad (Hambre/Muerte):** Añadir una penalización por inactividad. Si el usuario no "alimenta" la pecera en un lapso determinado (ej. 48 horas), los peces comenzarían a desaparecer del inventario, añadiendo un componente de retención (tipo *Tamagotchi*).
* **Animación Avanzada (WebGL/Canvas):** Migrar las animaciones CSS puras a una biblioteca como *Three.js* o *PixiJS* para lograr movimientos de natación no lineales (flocking) y rotaciones basadas en la dirección del movimiento, aumentando el realismo.

## 6. Batería de Pruebas (Unidad e Integración)

Se ha diseñado y ejecutado un plan de pruebas para garantizar el cumplimiento de los requisitos.

| **ID** | **Tipo** | **Módulo / Funcionalidad** | **Descripción de la Prueba (Entrada/Acción)** | **Salida Esperada** | **Resultado** |
| --- | --- | --- | --- | --- | --- |
| **PU-1** | Unidad | Autenticación (inicioSesion.php) | Intentar iniciar sesión introduciendo el usuario válido 'admin' pero una contraseña incorrecta '12345'. | El sistema no concede acceso y muestra un mensaje de error advirtiendo de credenciales inválidas. | Éxito |
| **PU-2** | Unidad | Registro (registro.php) | Enviar el formulario de registro dejando el campo 'Contraseña' vacío. | La validación detecta el campo vacío, detiene la inserción y muestra un mensaje de error solicitando completar todos los campos. | Éxito |
| **PU-3** | Unidad | Economía (script.js - Compras) | Intentar comprar un ítem cuyo precio (ej. 50$) es superior al dinero actual del usuario (ej. 10$). | La lógica JS intercepta la acción antes del fetch, mostrando una alerta (alert()) indicando falta de fondos. No se realiza petición al backend. | Éxito |
| **PU-4** | Unidad | Interfaz (script.js - Vaciar) | Pulsar el botón "Vaciar Pecera" y seleccionar "Cancelar" en el cuadro de diálogo de confirmación. | El evento se detiene. No se envía petición a vaciar\_inventario.php y los elementos del DOM (peces) permanecen intactos. | Éxito |
| **PU-5** | Unidad | Informes (generar\_informe.php) | Estando autenticado, pulsar el botón "Descargar Informe de la Pecera". | El navegador inicia la descarga de un archivo .txt estructurado, mostrando el nombre del usuario y los contadores correctos consultados en BD. | Éxito |
| **PU-6** | Unidad | Mecánica (script.js - Alimentar) | Hacer clic una vez en el botón "Comida". | Las variables locales dinero y xpActual incrementan (+1 y +10). Se dispara la animación de la bolita de comida en el DOM temporalmente. | Éxito |
| **PI-1** | **Integración** | Flujo completo: Economía, UI y Base de Datos | 1. Clicar en "Comida" hasta que la XP alcance el máximo para subir de nivel. 2. Verificar el incremento de nivel y el bono de dinero en la UI. 3. Comprar un "Pez Payaso" y verificar que el saldo se reduce. 4. Recargar la página (F5) para forzar la relectura desde el servidor. | Tras la recarga, el nivel incrementado, el saldo modificado y el nuevo pez persisten, demostrando que la interacción UI -> JS -> Fetch API -> PHP -> MySQL funciona correctamente. | Éxito |

## 7. Preguntas Obligatorias

**¿Ha podido cumplir la planificación? ¿Qué problemas ha tenido?**

Sí, en términos generales se han cumplido los plazos estipulados en las fases de análisis, diseño e implementación. El mayor desafío que supuso un ligero desvío en la planificación de la fase de codificación fue la gestión de la asincronía. Integrar el Frontend (interacciones rápidas en JavaScript) con el Backend (persistencia en PHP/MySQL) mediante llamadas AJAX (fetch()) requirió reestructurar ciertas funciones. Fue necesario asegurar que la interfaz de usuario no se desincronizara del estado real de la base de datos durante eventos rápidos, como múltiples clics en el botón de alimentación o compras consecutivas, requiriendo el uso cuidadoso de promesas.

**¿Su proyecto necesita algún tipo de permiso o autorización administrativa?**

No. Al tratarse de una aplicación web lúdica (un simulador de acuario/juego idle) desarrollada con fines educativos, no requiere de permisos ni autorizaciones administrativas especiales. El sistema no almacena datos personales sensibles ni información real de los usuarios, ya que los perfiles y su progresión son datos de juego ficticios generados en un entorno de pruebas cerrado.

**¿Ha establecido algún documento de prevención de riesgos laborales?**

Dado que la naturaleza del proyecto se circunscribe al desarrollo de software puro en un entorno digital, no se requiere la elaboración de un plan de prevención de riesgos laborales industriales complejo. No obstante, durante el transcurso del desarrollo se han observado y aplicado las normativas y recomendaciones básicas de ergonomía aplicables a puestos equipados con Pantallas de Visualización de Datos (PVD), incluyendo el mantenimiento de una postura correcta, distancias adecuadas a los monitores, iluminación apropiada del entorno de trabajo y la realización de pausas visuales periódicas para prevenir la fatiga.
