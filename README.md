## Crear la estructura de carpetas requerida

📌 A partir de la raíz del proyecto se ha propuesto la siguiente estructura de carpetas con las que implementaremos nuestra arquitectura.

```bash
mkdir -p app/Domain/Entities app/Domain/Repositories
mkdir -p app/Application/DTOs app/Application/UseCases
mkdir -p app/Infrastructure/Persistence
mkdir -p app/Presentation/Http/Controllers app/Presentation/Requests
```
## Agregar entidades al Dominio
🔧 Para nuestro ejemplo agregaremos la entidad ```Order.php``` en el directorio ```app/Domain/Entities```.

🔧 Dentro definiremos una función ```create()```, la cual se encargará de construir la entidad del negocio a la vez que esta estará fuertemente desacoplada del framework.

### ¿Para qué sirve la entidad en la arquitectura limpia?
📌 En la arquitectura limpia, una entidad representa el modelo de dominio puro de nuestra aplicación. Es una clase que encapsula reglas de negocio y mantiene los datos sin depender de ninguna tecnología externa (como Laravel, bases de datos o frameworks).

💡 La entidad NO debe saber nada de Eloquent, bases de datos ni infraestructuras externas.

### Beneficios de usar entidades
✅ Código más limpio y desacoplado (Evita el acoplamiento con Laravel y Eloquent).

✅ Pruebas unitarias más fáciles (no necesitamos Laravel para probar).

✅ Cumple con los principios SOLID (especialmente S de Single Responsibility y D de Dependency Inversion).

✅ Facilita cambios de infraestructura (por ejemplo, si cambiamos de MySQL a MongoDB, la entidad sigue funcionando).

✅ Separa la lógica de negocio de la base de datos.

✅ Permite escribir reglas de negocio en un solo lugar.

✅ Hace que el código sea más flexible y fácil de probar.

**Nota:** Cuando no se utilizan arquitecturas limpias, es común ocupar la instancia de algún modelo como entidad. A continuación, algunas diferencias:

| **Entidad (Dominio)**              | **Modelo de Base de Datos (Infraestructura)** |
|------------------------------------|-----------------------------------------------|
| No depende de Eloquent             | Extiende Model de Laravel                     |
| Representa un objeto del negocio   | Representa una tabla en la BD                 |
| Encapsula reglas de negocio        | Define la estructura de datos                 |
| Puede usarse sin Laravel           | Depende de Laravel y Eloquent                 |