<?

$table_id = $router->getPath()[1];
$table = new Table($table_id);

$post_id = $router->getPath()[2];
$post = new Post($post_id);
$post->getTable($table->tableName());

$field = $router->getPath()[3];


//echo $post->postId();
//echo $table->tableName();


$arr_photos = $post->getJsonField($field);

//$arr_thumbs = $post->getThumbs($field);
//$arr_marked = $post->getImagesMarked($field);
?>
<div id="container"></div>

<div class="side-buttons">
    <div class="button-cont">
        <?foreach($arr_photos as $key=>$value){?>
            <div class="button" data-image="<?=$arr_photos[$key]?>">
                <div class="thumb_360 background-fix" style="background-image: url( '<?=$value?>'); ">

                </div>
            </div>
        <?}?>
    </div>
</div>


<style>
    body {
        background-color: limegreen;
        margin: 0;
        overflow: hidden;
        height: 100%;
    }

    .button {
        display: flex;
        background: grey;
    }

    .side-buttons{
        top: 0;
        bottom: 0;
        right: 0;
        position: fixed;
        z-index: 9999;
        overflow-y: scroll;
    }

    .button-cont{

    }

    .thumb_360{
        width: 150px;
        height: 100px;
        cursor: pointer;
    }

    .background-fix{
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script src="<?=PROJECT_URL?>/libs/front/three/three.js"></script>
<script>

    function cleanCanvas(container){
        container.innerHTML ='';
    }

    function repaintCanvas(url, container){
        url = String(url);

        let material = new THREE.MeshBasicMaterial( {
            map: THREE.ImageUtils.loadTexture( url )
        } );

        let geometry = new THREE.SphereGeometry( 500, 60, 40 );
        geometry.applyMatrix( new THREE.Matrix4().makeScale( -1, 1, 1 ) );

        let mesh = new THREE.Mesh( geometry, material );

        scene.add( mesh );

        renderer = new THREE.WebGLRenderer();
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        container.appendChild( renderer.domElement );

        //$("#container").find('canvas').animate({opacity:"0.1"},0);
        //$("#container").find('canvas').animate({opacity:"1"},1000);
    }

    $('body').on('click','.button',function(){
        let url = this.getAttribute('data-image');
        $("#container").find('canvas').animate({opacity:"0.1"},1000);

        let container = document.getElementById('container');

        setTimeout(cleanCanvas,1000, container);
        setTimeout(repaintCanvas,1001, url, container);


    });



    var URL1 = '/uploads/objects/3191/4k-360-vr-immersive-virtual-footage-090902727_prevstill_d668c5c520f8e0a2cf7e1b3ca9da398c.jpeg';
    //var URL = '/uploads/objects/3191/4k-360-vr-video-moscow-footage-080020694_prevstill_375749e21258a29aec86c60cc017324d.jpeg';
    //var URL = '/uploads/objects/3191/148614_2e7e62068b5ebf322e00cc2c48ed53a6_ba1adb2f36711d21c8ae6e8b57246974.jpg';
    var URL = '<?=$arr_photos[0]?>';




    THREE.ImageUtils.crossOrigin = '';
    var camera, scene, renderer;

    var isUserInteracting = false,
        onMouseDownMouseX = 0, onMouseDownMouseY = 0,
        lon = 0, onMouseDownLon = 0,
        lat = 0, onMouseDownLat = 0,
        phi = 0, theta = 0;

    init();
    animate();

    function init() {

        var container, mesh;

        container = document.getElementById( 'container' );

        camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 1100 );
        camera.target = new THREE.Vector3( 0, 0, 0 );

        scene = new THREE.Scene();

        var geometry = new THREE.SphereGeometry( 500, 60, 40 );
        geometry.applyMatrix( new THREE.Matrix4().makeScale( -1, 1, 1 ) );

        var material = new THREE.MeshBasicMaterial( {
            map: THREE.ImageUtils.loadTexture( URL )
        } );

        mesh = new THREE.Mesh( geometry, material );

        scene.add( mesh );

        renderer = new THREE.WebGLRenderer();
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        container.appendChild( renderer.domElement );

        document.addEventListener( 'mousedown', onDocumentMouseDown, false );
        document.addEventListener( 'mousemove', onDocumentMouseMove, false );
        document.addEventListener( 'mouseup', onDocumentMouseUp, false );
        document.addEventListener( 'mousewheel', onDocumentMouseWheel, false );
        document.addEventListener( 'DOMMouseScroll', onDocumentMouseWheel, false);

//

        document.addEventListener( 'dragover', function ( event ) {

            event.preventDefault();
            event.dataTransfer.dropEffect = 'copy';

        }, false );

        document.addEventListener( 'dragenter', function ( event ) {

            document.body.style.opacity = 0.5;

        }, false );

        document.addEventListener( 'dragleave', function ( event ) {

            document.body.style.opacity = 1;

        }, false );

        document.addEventListener( 'drop', function ( event ) {

            event.preventDefault();

            var reader = new FileReader();
            reader.addEventListener( 'load', function ( event ) {

                material.map.image.src = event.target.result;
                material.map.needsUpdate = true;

            }, false );
            reader.readAsDataURL( event.dataTransfer.files[ 0 ] );

            document.body.style.opacity = 1;

        }, false );




//

        window.addEventListener( 'resize', onWindowResize, false );

    }

    function onWindowResize() {

        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();

        renderer.setSize( window.innerWidth, window.innerHeight );

    }

    function onDocumentMouseDown( event ) {

        event.preventDefault();

        isUserInteracting = true;

        onPointerDownPointerX = event.clientX;
        onPointerDownPointerY = event.clientY;

        onPointerDownLon = lon;
        onPointerDownLat = lat;

    }

    function onDocumentMouseMove( event ) {

        if ( isUserInteracting === true ) {

            lon = ( onPointerDownPointerX - event.clientX ) * 0.1 + onPointerDownLon;
            lat = ( event.clientY - onPointerDownPointerY ) * 0.1 + onPointerDownLat;

        }

    }

    function onDocumentMouseUp( event ) {

        isUserInteracting = false;

    }

    function onDocumentMouseWheel( event ) {

// WebKit

        if ( event.wheelDeltaY ) {

            camera.fov -= event.wheelDeltaY * 0.05;

// Opera / Explorer 9

        } else if ( event.wheelDelta ) {

            camera.fov -= event.wheelDelta * 0.05;

// Firefox

        } else if ( event.detail ) {

            camera.fov += event.detail * 1.0;

        }

        camera.updateProjectionMatrix();

    }

    function animate() {

        requestAnimationFrame( animate );
        update();

    }

    function update() {

        if ( isUserInteracting === false ) {

            //ЗДЕСЬ МЕНЯЕМ НА > 0 ДЛЯ АВТОПРОКРУТКИ
            lon += 0.0;

        }

        lat = Math.max( - 85, Math.min( 85, lat ) );
        phi = THREE.Math.degToRad( 90 - lat );
        theta = THREE.Math.degToRad( lon );

        camera.target.x = 500 * Math.sin( phi ) * Math.cos( theta );
        camera.target.y = 500 * Math.cos( phi );
        camera.target.z = 500 * Math.sin( phi ) * Math.sin( theta );

        camera.lookAt( camera.target );

        /*
        // distortion
        camera.position.copy( camera.target ).negate();
        */

        renderer.render( scene, camera );

    }
</script>

