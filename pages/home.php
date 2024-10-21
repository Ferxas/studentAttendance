<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de parte académico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background-color: #f0f0f0; }
        .container { padding: 20px; }
        #model-container { width: 45rem; height: 30rem; margin: auto; }
    </style>
</head>
<body>
    <div class="page-title text-dark" id="inicio">Sistema de parte académico</div>
    <a class="nav-link <?= (isset($page)) && $page == 'home' ? 'active' : '' ?>" href="./">
        <i class="fa-solid fa-house">Home</i>
    </a>
    <hr>
    <div class="container">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo tempore hic at quibusdam blanditiis sunt, obcaecati explicabo veniam provident odit quisquam dolores? Facilis earum illum maxime neque excepturi totam quasi?</p>
        <div class="row">
            <div class="text-center">
                <div id="model-container"></div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tween.js/18.6.4/tween.umd.js"></script>
    <script>
        // Configuración de Three.js
        const container = document.getElementById('model-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.5;
        renderer.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer.domElement);

        // Fondo personalizado (gradiente)
        const bgColors = [new THREE.Color(0x2c3e50), new THREE.Color(0xeff2f4)];
        const bgTexture = createGradientTexture(bgColors);
        scene.background = bgTexture;

        // Función para crear textura de gradiente
        function createGradientTexture(colors) {
            const canvas = document.createElement('canvas');
            canvas.width = 2;
            canvas.height = 2;
            const ctx = canvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 2);
            gradient.addColorStop(0, colors[0].getStyle());
            gradient.addColorStop(1, colors[1].getStyle());
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 2, 2);
            const texture = new THREE.CanvasTexture(canvas);
            texture.magFilter = THREE.LinearFilter;
            texture.minFilter = THREE.LinearFilter;
            return texture;
        }

        // Iluminación mejorada
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
        scene.add(ambientLight);

        const directionalLight1 = new THREE.DirectionalLight(0xffffff, 0.6);
        directionalLight1.position.set(1, 1, 1);
        scene.add(directionalLight1);

        const directionalLight2 = new THREE.DirectionalLight(0xffffff, 0.4);
        directionalLight2.position.set(-1, -1, -1);
        scene.add(directionalLight2);

        // Controles de órbita
        const controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;

        // Posicionar la cámara inicialmente
        camera.position.set(0, 5, 10);

        // Cargar el modelo GLB
        const loader = new THREE.GLTFLoader();
        loader.load(
            './models/Tigerweb.glb', // Cambia esto a la ruta de tu archivo .glb
            function (gltf) {
                const model = gltf.scene;
                scene.add(model);

                // Centrar y escalar el modelo
                const box = new THREE.Box3().setFromObject(model);
                const center = box.getCenter(new THREE.Vector3());
                model.position.sub(center);
                
                const size = box.getSize(new THREE.Vector3());
                const maxDim = Math.max(size.x, size.y, size.z);
                const scale = 2 / maxDim;
                model.scale.multiplyScalar(scale);

                // Calcular la posición de la cámara para el zoom
                const distance = maxDim * 0.2; // Ajusta este valor para acercar o alejar
                const direction = new THREE.Vector3(0, 0, 0.1).normalize();
                const targetPosition = direction.multiplyScalar(distance);

                // Animar la cámara para hacer zoom
                new TWEEN.Tween(camera.position)
                    .to(targetPosition, 7000) // 5000 ms de duración
                    .easing(TWEEN.Easing.Cubic.InOut)
                    .start();

                new TWEEN.Tween(controls.target)
                    .to(new THREE.Vector3(0, 0, 0), 5000)
                    .easing(TWEEN.Easing.Cubic.InOut)
                    .start();

                // Ajustar la posición de la cámara
                controls.update();
            },
            function (xhr) {
                console.log((xhr.loaded / xhr.total * 100) + '% cargado');
            },
            function (error) {
                console.error('Un error ocurrió al cargar el modelo', error);
            }
        );

        // Manejar el redimensionamiento de la ventana
        window.addEventListener('resize', onWindowResize, false);
        function onWindowResize() {
            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        }

        // Función de animación
        function animate(time) {
            requestAnimationFrame(animate);
            TWEEN.update(time);
            controls.update();
            renderer.render(scene, camera);
        }
        animate();
    </script>
</body>
</html>