
	var character
var hero = function() {

				var configOgro = {

					baseUrl: "models/",

					body: "ogro-light.js",
					skins: [ "grok.jpg"],
					weapons:  [ [ "weapon-light.js", "weapon.jpg" ] ],
					animations: {
						move: "run",
						idle: "stand",
						jump: "jump",
						attack: "attack",
						crouchMove: "cwalk",
						crouchIdle: "cstand",
						crouchAttach: "crattack"
					},

					walkSpeed: 39,
					crouchSpeed: 175

				};

				var nRows = 1;
				var nSkins = configOgro.skins.length;

				nCharacters = 1;

				for ( var i = 0; i < nCharacters; i ++ ) {

					character = new THREE.MD2CharacterComplex();
					character.scale = .3;
					character.idle = 'jump';
                    console.log(character)
					character.controls = controls;

					characters.push( character );


				}

				baseCharacter = new THREE.MD2CharacterComplex();
				baseCharacter.scale = 3;

				baseCharacter.onLoadComplete = function () {

					var k = 0;

					for ( var j = 0; j < 1; j ++ ) {

						for ( var i = 0; i < nSkins; i ++ ) {

							var cloneCharacter = characters[ k ];
                              
							cloneCharacter.shareParts( baseCharacter );

							// cast and receive shadows
							cloneCharacter.enableShadows( true );
                               cloneCharacter.castShadow = true;
							cloneCharacter.setWeapon( 0 );
							cloneCharacter.setSkin( i );
 
							cloneCharacter.root.position.x = 49.83765907522168;
							cloneCharacter.root.position.y = 5;
							cloneCharacter.root.position.z = -72.08174283162742;
							scene.add( cloneCharacter.root );
             

							k ++;

						}

					}

				 var gyro = new THREE.Gyroscope();
					

					characters[0].root.add( gyro );
                    gyro.add(camera);
                     
				};
                      
			return	baseCharacter.loadParts( configOgro );
                   

				}