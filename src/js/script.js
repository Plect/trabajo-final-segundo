document.addEventListener('DOMContentLoaded', () => {
    // 1. SESIÓN Y VARIABLES
    const pecera = document.querySelector('.cristalera');
    const seccionPecera = document.querySelector('.pecera');
    const seccionPeces = document.querySelector('.peces');
    const seccionDecoraciones = document.querySelector('.decoraciones');
    const seccionCorales = document.querySelector('.corales');
    const seccionEstrella = document.querySelector('.estrella');
    const seccionConfiguracion = document.querySelector('.configuracion');
    const seccionFondos = document.querySelector('.fondos');
    
    const fullscreenBtn = document.getElementById('fullscreen-boton');
    const btnPeces = document.getElementById('peces');
    const btnDecoraciones = document.getElementById('decoraciones');
    const btnCorales = document.getElementById('corales');
    const btnNivel = document.getElementById('nivel');
    const btnConfiguracion = document.getElementById('configuracion');
    const btnFondos = document.getElementById('fondo');
    const btnCerrarSesion = document.getElementById('btn-cerrar-sesion');
    const inputFondoPersonalizado = document.getElementById('input-fondo-personalizado');
    const btnSubirFondo = document.getElementById('btn-subir-fondo');
    const btnAyuda = document.getElementById('btn-ayuda');
    const btnVaciarPecera = document.getElementById('btn-vaciar-pecera');
    const btnDescargarInforme = document.getElementById('btn-descargar-informe');
    const contenedorAgua = pecera || seccionPecera;

    // Ocultar secciones al inicio de forma segura
    if(seccionPeces) seccionPeces.style.display = 'none';
    if(seccionDecoraciones) seccionDecoraciones.style.display = 'none';
    if(seccionCorales) seccionCorales.style.display = 'none';
    if(seccionEstrella) seccionEstrella.style.display = 'none';
    if(seccionConfiguracion) seccionConfiguracion.style.display = 'none';
    if(seccionFondos) seccionFondos.style.display = 'none';

    function checkUserSession() {
        fetch('check_session.php').then(r => r.json())
            .then(d => { if (!d.loggedin) window.location.href = 'webs/inicioSesion.php'; })
            .catch(() => window.location.href = 'webs/inicioSesion.php');
    }

    function cambiarPantalla(pantallaActiva) {
        const tiendas = [seccionPeces, seccionDecoraciones, seccionCorales, seccionEstrella, seccionConfiguracion, seccionFondos];
        tiendas.forEach(s => { if (s) s.style.display = 'none'; });
        
        if (pantallaActiva === seccionPecera) {
            seccionPecera.classList.remove('oculta-pero-activa');
        } else {
            seccionPecera.classList.add('oculta-pero-activa');
            if(pantallaActiva) pantallaActiva.style.display = 'block';
        }
    }

    function aplicarFondo(url) {
        if (!pecera || !url) return;
        pecera.style.backgroundImage = `url('${url}')`;
        localStorage.setItem('peceraFondo', url);
    }

    function inicializarFondoGuardado() {
        const fondoGuardado = localStorage.getItem('peceraFondo');
        if (fondoGuardado) aplicarFondo(fondoGuardado);
    }

    function configurarTienda(btn, seccionTienda) {
        if (!btn || !seccionPecera || !seccionTienda) return;
        seccionTienda.style.width = '60%';

        btn.addEventListener('click', () => {
            const estaAbierta = seccionTienda.style.display === 'block';
            cambiarPantalla(estaAbierta ? seccionPecera : seccionTienda);
        });

        const btnCerrar = seccionTienda.querySelector('.btn-volver-pecera, #btn-volver-pecera');
        if (btnCerrar) {
            btnCerrar.addEventListener('click', () => cambiarPantalla(seccionPecera));
        }
    }

    function setupFullscreen() {
        if (!fullscreenBtn || !pecera) return;
        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                if (pecera.requestFullscreen) pecera.requestFullscreen();
                else if (pecera.webkitRequestFullscreen) pecera.webkitRequestFullscreen();
                else if (pecera.msRequestFullscreen) pecera.msRequestFullscreen();
            } else document.exitFullscreen();
        });
        document.addEventListener('fullscreenchange', () => {
            fullscreenBtn.textContent = document.fullscreenElement ? 'Salir de Pantalla' : 'Pantalla Completa';
        });
    }

    function actualizarContadorPeces() {
        const contadorDiv = document.querySelector('.estrella .centro p:last-child');
        if (contadorDiv) {
            const totalPeces = document.querySelectorAll('.pez-animado').length;
            contadorDiv.innerText = `🐟 Cantidad: ${totalPeces}`;
        }
    }

    function crearElementoMovil(tipoClase, icono, ancho) {
        if (!contenedorAgua || !icono) return;
        const elemento = document.createElement('div');
        elemento.classList.add(tipoClase);
        if (icono.includes('.png') || icono.includes('.jpg')) {
            elemento.innerHTML = `<img src="${icono}" alt="${tipoClase}" style="width: ${ancho}px; height: auto;">`; 
        } else elemento.innerHTML = icono;

        if (tipoClase === 'pez-animado') {
            elemento.style.top = `${Math.floor(Math.random() * 70) + 10}%`;
            elemento.style.animationDuration = `${Math.floor(Math.random() * 8) + 12}s`;
        } else {
            elemento.style.left = `${Math.floor(Math.random() * 80) + 10}%`;
        }
        contenedorAgua.appendChild(elemento);
        actualizarContadorPeces();
    }

    function crearPezEnAcuario(iconoPez) { crearElementoMovil('pez-animado', iconoPez, 100); }
    function crearDecoracionEnAcuario(iconoDecoracion) { crearElementoMovil('decoracion-animada', iconoDecoracion, 120); }
    function crearCoralEnAcuario(iconoCoral) { crearElementoMovil('coral-animado', iconoCoral, 90); }

    function cargarItems(term, url, callback) {
        fetch(url).then(r => r.ok ? r.json() : []).then(items => {
            if (Array.isArray(items)) items.forEach(item => callback(item.tipo));
        }).catch(e => console.error(e));
    }

    function configurarCompras() {
        const botones = document.querySelectorAll('.btn-comprar, .btn-comprar-deco, .btn-comprar-coral');
        if (!botones) return;

        // 1. Diccionario con los precios de tu catálogo (ID : Precio)
        const precios = {
            101: 10, 102: 25, 103: 40, // Peces
            201: 5, 202: 15, 203: 12, // Decoraciones
            301: 20, 302: 30, 303: 35  // Corales
        };

        botones.forEach(boton => {
            boton.addEventListener('click', () => {
                const idItem = boton.getAttribute('data-id');
                const precio = precios[idItem] || 0; // Averiguamos cuánto cuesta

                // 2. Comprobamos si el usuario es lo bastante rico 🧐
                if (dinero < precio) {
                    alert('¡No tienes suficiente dinero! 💸 Alimenta a los peces para ganar más.');
                    return; // Detenemos la compra
                }

                const formData = new FormData();
                let url = '', crear = null;
                const tipoPez = boton.getAttribute('data-pez');
                const tipoDecoracion = boton.getAttribute('data-decoracion');
                const tipoCoral = boton.getAttribute('data-coral');

                if (tipoPez) { formData.append('pez_id', idItem); url = 'guardar_pez.php'; crear = crearPezEnAcuario; }
                else if (tipoDecoracion) { formData.append('decoracion_id', idItem); url = 'guardar_decoracion.php'; crear = crearDecoracionEnAcuario; }
                else if (tipoCoral) { formData.append('coral_id', idItem); url = 'guardar_coral.php'; crear = crearCoralEnAcuario; }

                if (!url || !crear) return;

                // 3. Si todo va bien, compramos y restamos el dinero
                fetch(url, { method: 'POST', body: formData }).then(() => {
                    
                    // Restamos el coste y actualizamos el panel de la Estrella
                    dinero -= precio;
                    actualizarUIStats();

                    // Guardamos el nuevo dinero en la base de datos al instante
                    const statsData = new FormData();
                    statsData.append('dinero', dinero);
                    statsData.append('nivel', nivel);
                    statsData.append('xp_actual', xpActual);
                    statsData.append('xp_max', xpMax);
                    fetch('guardar_stats.php', { method: 'POST', body: statsData }).catch(e => console.error(e));

                    // Finalmente, dibujamos el pez y volvemos a la pecera
                    crear(tipoPez || tipoDecoracion || tipoCoral);
                    cambiarPantalla(seccionPecera);
                }).catch(e => console.error(e));
            });
        });
    }

    // -------------------------
    // LÓGICA DE INICIO
    // -------------------------
    checkUserSession();
    setupFullscreen();
    inicializarFondoGuardado();
    
    configurarTienda(btnPeces, seccionPeces);
    configurarTienda(btnDecoraciones, seccionDecoraciones);
    configurarTienda(btnCorales, seccionCorales);
    configurarTienda(btnNivel, seccionEstrella);
    configurarTienda(btnConfiguracion, seccionConfiguracion);
    configurarTienda(btnFondos, seccionFondos);

    // EventListener para descargar informe
    if (btnDescargarInforme) {
        btnDescargarInforme.addEventListener('click', () => {
            window.location.href = 'generar_informe.php';
        });
    }

    // Fondos personalizados
    document.querySelectorAll('.fondo-thumb').forEach(thumbnail => {
        thumbnail.addEventListener('click', () => aplicarFondo(thumbnail.dataset.fondo));
    });

    if (btnSubirFondo && inputFondoPersonalizado) {
        btnSubirFondo.addEventListener('click', () => inputFondoPersonalizado.click());
        inputFondoPersonalizado.addEventListener('change', (e) => {
            const file = e.target.files ? e.target.files[0] : null;
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = () => { if (reader.result) aplicarFondo(reader.result); };
            reader.readAsDataURL(file);
        });
    }

    // Ayuda
    if (btnAyuda) {
        btnAyuda.addEventListener('click', () => {
            alert('🐟 BIENVENIDO A TU PECERA DIGITAL 🐟\n\n1. Pulsa [Comida] para alimentar a la pecera.\n2. Ganarás 1$ y 10 XP por cada clic.\n3. Al llenar tu barra de XP subirás de nivel y ganarás un gran bono de monedas.\n4. Usa tus monedas en las tiendas de Peces, Decoraciones y Corales para personalizar tu acuario.\n5. Puedes subir tu propio fondo en la sección [Fondo de pantalla].\n\n¡Disfruta de tu ecosistema!');
        });
    }

    // Vaciar Pecera
    if (btnVaciarPecera) {
        btnVaciarPecera.addEventListener('click', () => {
            if (confirm('¿Estás seguro de que quieres vaciar la pecera? Perderás todo.')) {
                // Enviar petición fetch para borrar inventario de la base de datos
                fetch('vaciar_inventario.php', { method: 'POST' })
                    .then(response => response.text())
                    .then(result => {
                        if (result === 'Exito') {
                            // El borrado fue exitoso en la BD, ahora eliminar del DOM
                            document.querySelectorAll('.pez-animado, .decoracion-animada, .coral-animado').forEach(el => el.remove());
                            actualizarContadorPeces();
                            
                            // Resetear estadísticas a valores por defecto
                            dinero = 90;
                            nivel = 1;
                            xpActual = 0;
                            xpMax = 100;
                            actualizarUIStats();
                            
                            // Guardar los cambios de estadísticas en la base de datos
                            const statsData = new FormData();
                            statsData.append('dinero', dinero);
                            statsData.append('nivel', nivel);
                            statsData.append('xp_actual', xpActual);
                            statsData.append('xp_max', xpMax);
                            fetch('guardar_stats.php', { method: 'POST', body: statsData }).catch(e => console.error(e));
                            
                            cambiarPantalla(seccionPecera);
                        } else {
                            console.error('Error al vaciar la pecera:', result);
                            alert('Hubo un error al vaciar la pecera. Por favor, intenta de nuevo.');
                        }
                    })
                    .catch(error => {
                        console.error('Error en la petición fetch:', error);
                        alert('Error de conexión. Por favor, intenta de nuevo.');
                    });
            }
        });
    }

    // Borde Spotlight
    const bordeInteractivo = document.querySelector('.borde-interactivo');
    if (bordeInteractivo) {
        bordeInteractivo.addEventListener('mousemove', (e) => {
            const rect = bordeInteractivo.getBoundingClientRect();
            bordeInteractivo.style.setProperty('--x', `${e.clientX - rect.left}px`);
            bordeInteractivo.style.setProperty('--y', `${e.clientY - rect.top}px`);
        });
    }

    if (btnCerrarSesion) {
        btnCerrarSesion.addEventListener('click', () => window.location.href = 'webs/logout.php');
    }

    // Cargar inventario al entrar
    cargarItems('peces', 'cargar_peces.php', crearPezEnAcuario);
    cargarItems('decoraciones', 'cargar_decoraciones.php', crearDecoracionEnAcuario);
    cargarItems('corales', 'cargar_corales.php', crearCoralEnAcuario);
    configurarCompras();

    // -------------------------
    // ECONOMÍA Y CLIMA
    // -------------------------
    let dinero, nivel, xpActual, xpMax;

    function actualizarUIStats() {
        const pDinero = document.getElementById('dinero-display');
        const pNivel = document.getElementById('nivel-display');
        const pXp = document.getElementById('xp-display');
        
        if (pDinero) pDinero.innerText = `💲 ${dinero}`;
        if (pNivel) pNivel.innerText = `Lvl ${nivel}`;
        if (pXp) pXp.innerText = `⭐ ${xpActual} xp / ${xpMax} xp`;
    }

    fetch('obtener_stats.php').then(r => r.json()).then(data => {
        dinero = data.error ? 90 : (data.dinero || 90);
        nivel = data.error ? 1 : (data.nivel || 1);
        xpActual = data.error ? 0 : (data.xp_actual || 0);
        xpMax = data.error ? 100 : (data.xp_max || 100);
        actualizarUIStats();
    }).catch(() => {
        dinero = 90; nivel = 1; xpActual = 0; xpMax = 100;
        actualizarUIStats();
    });

    // Ajustes LocalStorage
    const comidaVisible = document.getElementById('comida-visible');
    const sonidoPecera = document.getElementById('sonido-pecera');
    const sonidoMusica = document.getElementById('sonido-musica');
    const selectTemp = document.getElementById('unidad-temperatura'); // Declarado solo 1 vez
    const temperaturaBarra = document.getElementById('temperatura');

    // Audios
    const audioPecera = document.getElementById('audio-pecera');
    const audioMusica = document.getElementById('audio-musica');

    function actualizarVolumen() {
        if (audioPecera) audioPecera.volume = sonidoPecera.value / 100;
        if (audioMusica) audioMusica.volume = sonidoMusica.value / 100;
    }

    if (comidaVisible) comidaVisible.checked = localStorage.getItem('comida-visible') !== 'false';
    if (sonidoPecera) sonidoPecera.value = localStorage.getItem('sonido-pecera') || 50;
    if (sonidoMusica) sonidoMusica.value = localStorage.getItem('sonido-musica') || 30;
    if (selectTemp) selectTemp.value = localStorage.getItem('unidad-temperatura') || 'celsius';

    actualizarVolumen();

    if (comidaVisible) comidaVisible.addEventListener('change', () => localStorage.setItem('comida-visible', comidaVisible.checked));
    if (sonidoPecera) sonidoPecera.addEventListener('input', () => {
        localStorage.setItem('sonido-pecera', sonidoPecera.value);
        actualizarVolumen();
    });
    if (sonidoMusica) sonidoMusica.addEventListener('input', () => {
        localStorage.setItem('sonido-musica', sonidoMusica.value);
        actualizarVolumen();
    });
    if (selectTemp) {
        selectTemp.addEventListener('change', () => {
            localStorage.setItem('unidad-temperatura', selectTemp.value);
            cargarTemperatura();
        });
    }

    // Temperatura de Algeciras
    function cargarTemperatura() {
        fetch('https://api.open-meteo.com/v1/forecast?latitude=36.13&longitude=-5.45&current_weather=true')
            .then(r => r.json())
            .then(data => {
                let temp = data.current_weather.temperature;
                const unidad = localStorage.getItem('unidad-temperatura') || 'celsius';
                if (unidad === 'fahrenheit') temp = (temp * 9/5) + 32;
                if (temperaturaBarra) temperaturaBarra.innerText = `${temp.toFixed(1)}°${unidad === 'fahrenheit' ? 'F' : 'C'}`;
            })
            .catch(() => { if (temperaturaBarra) temperaturaBarra.innerText = 'N/A'; });
    }
    cargarTemperatura();

    // Botón Comida
    const comidaBoton = document.getElementById('comida-boton');
    if (comidaBoton) {
        comidaBoton.addEventListener('click', () => {
            dinero += 1; 
            xpActual += 10;
            if (xpActual >= xpMax) {
                xpActual -= xpMax; 
                nivel += 1; 
                xpMax += 10;
                dinero += (30 + Math.floor(nivel / 10));
            }
            actualizarUIStats();

            const formData = new FormData();
            formData.append('dinero', dinero);
            formData.append('nivel', nivel);
            formData.append('xp_actual', xpActual);
            formData.append('xp_max', xpMax);
            fetch('guardar_stats.php', { method: 'POST', body: formData }).catch(e => console.error(e));

            if (comidaVisible && comidaVisible.checked) {
                const bolita = document.createElement('div');
                bolita.classList.add('comida-bolita');
                bolita.style.left = `${Math.random() * 80 + 10}%`;
                if (contenedorAgua) {
                    contenedorAgua.appendChild(bolita);
                    setTimeout(() => bolita.remove(), 3000);
                }
            }
        });
    }

    // Autoplay audio on first click
    document.body.addEventListener('click', () => {
        if (audioPecera) audioPecera.play();
        if (audioMusica) audioMusica.play();
    }, { once: true });
});