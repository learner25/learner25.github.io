
var villianGlobalPosition;
var follower;
var villian = function()
{
	loader.options.convertUpAxis = true;
	loader.load( './models/enemy.dae', function ( collada ) {

				dae = collada.scene;

				dae.traverse( function ( child ) {

					if ( child instanceof THREE.Mesh ) {
                        
						//var animation = new THREE.Animation( child, child.geometry.animation );
						//animation.play();
                        child.castShadow = true;
                        child.recieveShadow = true;
			//child.matrixAutoUpdate = false;
			child.geometry.applyMatrix(new THREE.Matrix4().makeRotationFromEuler(new THREE.Euler(Math.PI/2, Math.PI,0)));
			child.lookAt(character.root.position)
			 follower = child;
					}

				} );

				dae.scale.x = dae.scale.y = dae.scale.z = 1.9;
				dae.updateMatrix();
				villianGlobalPosition = dae;
				 villianGlobalPosition.matrixAutoUpdate = false;
				var geometry = new THREE.CylinderGeometry( 0, 10, 100, 3 );
				geometry.applyMatrix( new THREE.Matrix4().makeRotationFromEuler( new THREE.Euler( Math.PI/2, Math.PI, 0 ) ) );
				var material = new THREE.MeshNormalMaterial();
				var mesh = new THREE.Mesh( geometry, material );
				//scene.add( mesh );
				//follower = mesh;
 				

			

			} );

}