<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: webs/inicioSesion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pecera Digital</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div id="app">
        <section class="botones" id="izq-boton">
            <div class="boton">
                <button id="nivel">Estrella</button>
            </div>
            <div class="boton">
                <button id="configuracion">Configuracion</button>
            </div>
            <div class="boton">
                <button id="fondo">Fondo de pantalla</button>
            </div>
        </section>
        <section class="pecera">
           <section class="tapa">
                <div id="comida">
                    <button id="comida-boton">Comida</button>
                </div>
                <div id="funciones">
                    <div id="temperatura">25ºC</div>
                    <button id="fullscreen-boton">Pantalla Completa</button>
                    <div id="usuario"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                </div>
           </section> 
           <section class="cristalera">
                <img id="reflejoCristal" src="images/reflejoCristal.png" alt="Reflejo cristal" />
           </section>
        </section>
        <section class="peces">
            <div id="vista-tienda" class="tiendaFish">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Catálogo de Peces</h2>
                    <button class="btn-volver-pecera" style="padding: 10px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">Volver a la Pecera</button>
                </div>
                
                <div class="grid-peces">
                    <div class="carta-pez">
                        <h3>Pez Payaso</h3>
                        <p>Precio: 10 Monedas</p>
                        <button class="btn-comprar" data-id="101" data-pez="images/pez_payaso.png">Comprar</button>
                    </div>
                    <div class="carta-pez">
                        <h3>Pez Cirujano Azul</h3>
                        <p>Precio: 25 Monedas</p>
                        <button class="btn-comprar" data-id="102" data-pez="images/pez_cirujano.png">Comprar</button>
                    </div>
                    <div class="carta-pez">
                        <h3>Pez Ángel</h3>
                        <p>Precio: 40 Monedas</p>
                        <button class="btn-comprar" data-id="103" data-pez="images/pez_angel.png">Comprar</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="decoraciones">
            <div id="vista-tienda" class="tiendaDecoraciones">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Catálogo de Decoraciones</h2>
                <button class="btn-volver-pecera" style="padding: 10px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">Volver a la Pecera</button>
            </div>
            
            <div class="grid-decoraciones">
                <div class="carta-decoracion">
                <h3>Piedra Lisa</h3>
                <p>Precio: 5 Monedas</p>
                <button class="btn-comprar" data-id="201" data-decoracion="images/piedra.png">Comprar</button>
                </div>
                <div class="carta-decoracion">
                <h3>Estrella Marina</h3>
                <p>Precio: 15 Monedas</p>
                <button class="btn-comprar" data-id="202" data-decoracion="images/estrella.png">Comprar</button>
                </div>
                <div class="carta-decoracion">
                <h3>Concha</h3>
                <p>Precio: 12 Monedas</p>
                <button class="btn-comprar" data-id="203" data-decoracion="images/concha.png">Comprar</button>
                </div>
            </div>
            </div>
        </section>
        <section class="corales">
            <div id="vista-tienda" class="tiendaCorales">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Catálogo de Corales</h2>
                    <button class="btn-volver-pecera" style="padding: 10px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">Volver a la Pecera</button>
                </div>
                
                <div class="grid-decoraciones">
                    <div class="carta-decoracion">
                        <h3>Coral Rojo</h3>
                        <p>Precio: 20 Monedas</p>
                        <button class="btn-comprar" data-id="301" data-coral="images/coral_rojo.png">Comprar</button>
                    </div>
                    <div class="carta-decoracion">
                        <h3>Coral Tubo</h3>
                        <p>Precio: 30 Monedas</p>
                        <button class="btn-comprar" data-id="302" data-coral="images/coral_tubo.png">Comprar</button>
                    </div>
                    <div class="carta-decoracion">
                        <h3>Anémona</h3>
                        <p>Precio: 35 Monedas</p>
                        <button class="btn-comprar" data-id="303" data-coral="images/anemona.png">Comprar</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="estrella">
            <div class="tiendaEstrella">
                <div class="arriba-admin">
                    <button class="btn-volver-pecera">Volver a la Pecera</button>
                </div>
                <h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <div class="centro">
                    <h2 id="nivel-display">Lvl 1</h2>
                    <p id="xp-display">⭐ 0 xp / 100 xp</p>
                    <p id="dinero-display">💲 90</p>
                    <p>🐟 Cantidad: 0</p>
                </div>
                <button id="btn-descargar-informe" style="background: #2196F3; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; margin-bottom: 10px;">📄 Descargar Informe de la Pecera</button> 
                <br>
                <button id="btn-cerrar-sesion">Cerrar sesión</button>
            </div>
        </section>
        <section class="configuracion">
            <div id="vista-tienda" class="tiendaConfiguracion">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <button class="btn-volver-pecera" style="padding: 10px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">Volver a la Pecera</button>
                </div>
                <div class="borde-interactivo">
                    <div class="caja-ajustes">
                        <div class="control-ajuste" style="display: flex; align-items: center; gap: 12px;">
                            <input id="comida-visible" type="checkbox" checked>
                            <label for="comida-visible">Comida visible</label>
                        </div>
                        <div class="control-ajuste">
                            <label for="unidad-temperatura">Unidad de temperatura</label>
                            <select id="unidad-temperatura">
                                <option value="celsius">Grados Centígrados (ºC)</option>
                                <option value="fahrenheit">Grados Fahrenheit (ºF)</option>
                            </select>
                        </div>
                        <div class="control-ajuste">
                            <label for="sonido-pecera">Sonido pecera</label>
                            <input id="sonido-pecera" type="range" min="0" max="100" value="50">
                        </div>
                        <div class="control-ajuste">
                            <label for="sonido-musica">Música de fondo</label>
                            <input id="sonido-musica" type="range" min="0" max="100" value="30">
                        </div>
                        <div class="control-ajuste" style="text-align: center;">
                            <button id="btn-ayuda" style="padding: 12px 18px; background: linear-gradient(135deg, #4CAF50, #2E7D32); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: bold; box-shadow: 0 6px 12px rgba(46, 125, 50, 0.35); margin-bottom: 10px;">❓ Cómo jugar / Ayuda</button>
                            <button id="btn-vaciar-pecera" style="padding: 12px 18px; background: linear-gradient(135deg, #ff5f5f, #c0392b); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: bold; box-shadow: 0 6px 12px rgba(192, 57, 43, 0.35);">⚠️ Vaciar pecera</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="fondos">
            <div id="vista-tienda" class="tiendaFondos">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Selecciona tu fondo</h2>
                    <button class="btn-volver-pecera" style="padding: 10px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">Volver a la Pecera</button>
                </div>
                <div class="grid-fondos">
                    <img src="images/pecera.jpg" alt="Fondo 1" class="fondo-thumb" data-fondo="images/pecera.jpg">
                    <img src="images/pez_payaso.png" alt="Fondo 2" class="fondo-thumb" data-fondo="images/pez_payaso.png">
                    <img src="images/pez_cirujano.png" alt="Fondo 3" class="fondo-thumb" data-fondo="images/pez_cirujano.png">
                    <img src="images/pez_angel.png" alt="Fondo 4" class="fondo-thumb" data-fondo="images/pez_angel.png">
                </div>
                <div class="separador-fondo"></div>
                <div class="contenedor-subir-fondo">
                    <button id="btn-subir-fondo" type="button" class="fondo-upload-button">Subir imagen propia</button>
                    <input id="input-fondo-personalizado" type="file" accept="image/*" style="display: none;">
                </div>
            </div>
        </section>
        <section class="botones" id="der-boton">
            <div class="boton">
                <button id="peces">peces</button>
            </div>
            <div class="boton">
                <button id="decoraciones">Decoraciones</button>
            </div>
            <div class="boton">
                <button id="corales">corales</button>
            </div>
        </section>
    </div>
    <audio id="audio-pecera" loop>
        <source src="audio/burbujas.mp3" type="audio/mpeg">
    </audio>
    <audio id="audio-musica" loop>
        <source src="audio/musica.mp3" type="audio/mpeg">
    </audio>
</body>
</html>