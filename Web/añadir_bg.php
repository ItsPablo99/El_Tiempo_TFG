<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");      
include("recursos/php/conexion.php");

//Si existe un envio POST desde la pagina anterior
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Se extraen los datos del POST
    $id=$_POST['ID'];
    $nombre=$_POST['nombre'];
    $ubicacion=$_POST['ubicacion'];
    $codigo=$_POST['codigo'];

    //Se obtienen la cantidad de estaciones con el mismo nombre o ID
    $sql="SELECT COUNT(*) FROM estaciones WHERE ID='$id'"; 
    $same_id=$bbdd->query($sql)->fetch();
    $sql="SELECT COUNT(*) FROM estaciones WHERE Nombre='$nombre'"; 
    $same_name=$bbdd->query($sql)->fetch();
  
    //Si no existe ninguna estacion con el nombre o ID elegido
    if ($same_id[0] == 0 AND $same_name[0] == 0){ 

      //Se hashea el codigo de seguridad
      $hash= password_hash($codigo, PASSWORD_DEFAULT);

      //Se inserta en la base de datos la nueva estacion
      $sql="INSERT INTO estaciones (id,nombre,ubicacion,Cod_seguridad) VALUES ('$id','$nombre','$ubicacion','$hash')";
      $bbdd->query($sql);

      //Se muestra el codigo para el nuevo sensor
      echo'Introducido correctamente<br>Codigo para copiar:<br><br>
      <pre>

      //Variables a definir//
      const char* ssid = "'.$_POST['ssid'].'";                                  //Nombre de la red wifi a la que se concetara el sensor
      const char* password =  "'.$_POST['pass'].'";                             //Contraseña de la red wifi a la que se concetara el sensor
      const char* adress = "'.$_POST['url'].'";                                 //URL a la que se enviaran los datos
      const char* id =  "'.$id.'";                                              //ID del sensor
      const char* codigo =  "'.$codigo.'";                                      //Codigo de seguridad del sensor
      int  tiempo = '.$_POST['tiempo'].';                                       //Tiempo (en milisegundos) entre los envios de datos
      const char* rootCACertificate = \										                      //Certificado para la conexion HTTPS
      "-----BEGIN CERTIFICATE-----\n" \
      "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\n" \
      "-----END CERTIFICATE-----\n";
 
      //Librerias y definicones//
      #include &lt;WiFi.h&gt;														                              //Libreria para la conexion wifi
      #include &lt;WiFiClientSecure.h&gt;											                        //Libreria para la conexion segura por https
      #include &lt;HTTPClient.h&gt;													                          //Libreria para realizar peticiones web
      #include &lt;AHTxx.h&gt;                                                        //Libreria para comunicarse con el sensor
 
      AHTxx aht20(AHTXX_ADDRESS_X38, AHT2x_SENSOR);                             //Definicion del tipo de sensor y su direccion
 
      //Codigo inicial//
      void setup() {
        aht20.begin();                                                          //Se inicia la comunicacion con el sensor
        Serial.begin(9600);													                            //Se inicia la comunicacion serie para monitoreo
        pinMode(LED_BUILTIN, OUTPUT);                                           //Se define el LED integrado en la placa que se usara como indicador
        WiFi.mode(WIFI_STA);													                          //Se establece el modo de conexion wifi y se conecta con la ssid y contraseña
        WiFi.begin(ssid, password);
        Serial.println("Connectando WiFi");
        while (WiFi.status() != WL_CONNECTED) {								                  //Mientras se esta conectando al wifi se muestran puntos y se hace parpadear el LED
          Serial.print(&#39;.&#39;);
          digitalWrite(LED_BUILTIN, HIGH);                                     
          delay(100);                      
          digitalWrite(LED_BUILTIN, LOW);    
          delay(100);   
        }
        Serial.println(WiFi.localIP());                                         //Si la conexion es correcta se muestra la IP
      }
 
      //Codigo principal//
      void loop() {
        WiFiClientSecure *client = new WiFiClientSecure;								        //Se crea un objeto para la conexion
        if(client) {
          digitalWrite(LED_BUILTIN, HIGH); 											                //Se enciende el LED
          client->setCACert(rootCACertificate);										              //Se establece el certificado para la conexion
          HTTPClient http;                                                      //Se inicia el protocolo http
          String datos = "temp=" + String(aht20.readTemperature())+"&hum="+     //Se preparan los datos a enviar con las lecturas del sensor y las variables
          String(aht20.readHumidity()) +"&id="+id+"&codigo="+codigo;         
          http.begin(*client, "https://eltiempotfg.duckdns.org/post_datos.php");     
          http.addHeader("Content-Type", "application/x-www-form-urlencoded");      	//Se inicia la conexion con la URL indicada
          int codigo_respuesta = http.POST(datos);   									                //Se hace post de los datos y se obtiene la respuesta
          String txt_respuesta = http.getString();
          Serial.println("Codigo HTTP: "+String(codigo_respuesta));					          //Se muestra la respuesta del servidor 
          Serial.println("Respuesta servidor: ");
          Serial.println(txt_respuesta);                                                    
          http.end();                                                           		  //Se cierra la conexion HTTP
          delay(tiempo);                                                        		  //Se espera el tiempo indicado antes de volver a enviar los datos
        }
      }
      </pre>';
    
    //Si ya existe una estacion con el mismo nombre o ID
    }else{
      echo"Error: Ya existe la estacion";
    }
}
pie();
?>