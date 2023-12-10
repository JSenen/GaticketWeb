![PHP Shield](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![ChatGPT Shield](https://img.shields.io/badge/ChatGPT-00BFFF?style=for-the-badge&logo=chatbot&logoColor=white)
![Bootstrap Shield](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![jQuery Shield](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![MAMP Shield](https://img.shields.io/badge/MAMP-2C3A47?style=for-the-badge&logo=mamp&logoColor=white)



# GaticketWebApp 

Apliación Web para la gestión de tickets de incidencia por parte de los equipos de tecnologias de la información.

> La aplicación hace uso de la Api:
>https://jsenen.github.io/Gaticket_API/#/

- :warning: **Importante:** Para hacer uso de la tecnología chatGpt, se debe crear un fichero _**.env**_ dentro de la raiz del proyecto y dentro de el introducir la api key contratada con el nombre *MY_API_KEY*
> ```
> MY_API_KEY=************************
>```
***
Para el uso de la aplicación Web se debe tener en cuenta lo siguiente:
1. Debe usarse la Api antes indicada
2. En caso de usarse la imagen Docker de la Api, deberá arrancarse en primer lugar
3. Si se usa el ejemplo de base de datos incorporado a la Api. Existen 3 usuarios precreados.
    - admin / admin : Administrador del sistema
    - super / super : superusuario
    - user / user : usuario genérico

***
## Casos de uso

La imagen adjunta nos muestra los casos de uso de la aplición por parte de cualquiera de los actores implicados
 ![Imagen](https://github.com/JSenen/GatickerWeb/blob/develop/resources/img/Casos_de_uso.png)
   
### Seguridad HTTPS

Los archivos
1. server.csr.cnf
2. v3.ext
Se utulizan para simular un certificado **SSL** en local con la aplicacion MAMP. La cual nos genera un servidor Apache en local.





