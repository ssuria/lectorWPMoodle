# Integración con RemUI (Edwiser) Theme

Este documento explica cómo integrar y usar el bloque WordPress News con el tema RemUI de Edwiser, incluyendo el Page Builder.

## 🎨 ¿Cómo funciona con RemUI?

### Situación Actual

El plugin **WordPress News** es un **bloque estándar de Moodle**, lo que significa:

✅ **Funciona perfectamente con RemUI**
✅ **Usa estilos optimizados para RemUI automáticamente**
✅ **Compatible con el sistema de colores de RemUI**
✅ **Soporte para modo oscuro de RemUI**
❌ **NO aparece automáticamente en el Page Builder de Edwiser**

### ¿Por qué no aparece en el Page Builder?

El **Edwiser Page Builder** es una herramienta propietaria que trabaja con sus propios "widgets" personalizados. Los bloques estándar de Moodle no se convierten automáticamente en widgets del Page Builder.

## 📍 Cómo Añadir el Bloque en RemUI

### Método 1: Como Bloque Tradicional (Recomendado)

1. **Ir a la página donde quieres el bloque** (Home, Dashboard, etc.)
2. **Activar edición**
   - Click en "Turn editing on" / "Activar edición"
3. **Añadir bloque**
   - Click en "Add a block" / "Añadir un bloque"
   - Buscar "WordPress News"
   - Seleccionar y añadir
4. **Configurar el bloque**
   - Click en el icono de configuración (⚙️)
   - Ingresar URL de WordPress
   - Ajustar opciones de visualización
   - Guardar cambios

### Método 2: En el Home Page de RemUI

RemUI permite personalizar el home page con bloques:

1. **Site administration > Appearance > RemUI Settings**
2. **Front Page Settings**
3. En las regiones de bloques disponibles, añadir "WordPress News"

### Método 3: En My Moodle / Dashboard

1. **Ir a Dashboard** (My Moodle)
2. **Customize this page** / "Personalizar esta página"
3. **Add blocks** → "WordPress News"

## 🎨 Diseños Atractivos con RemUI

El plugin incluye **estilos específicos optimizados para RemUI** que se cargan automáticamente.

### Características de Diseño RemUI

#### 1. **Cards Modernas**
- Sombras suaves y elegantes
- Bordes redondeados (12px)
- Efectos hover con elevación
- Transiciones fluidas

#### 2. **Colores Adaptativos**
- Usa automáticamente los colores primarios de RemUI
- Variables CSS de RemUI (`--primary`, `--primary-dark`)
- Gradientes modernos en botones y badges

#### 3. **Layouts Responsivos**
- **Grid Layout**: 3 columnas en desktop, 2 en tablet, 1 en móvil
- **List Layout**: Diseño vertical optimizado
- Altura automática equalizada

#### 4. **Tipografía RemUI**
- Hereda fuentes de RemUI
- Tamaños y pesos optimizados
- Line-height perfecto para legibilidad

#### 5. **Modo Oscuro**
- Detección automática del modo oscuro de RemUI
- Colores adaptados para dark mode
- Contraste optimizado

## 🛠️ Personalización Avanzada

### Opción 1: Usar CSS Personalizado en RemUI

1. **Site administration > Appearance > RemUI Settings**
2. **Custom CSS** (o Advanced Settings)
3. Agregar estilos personalizados:

```css
/* Ejemplo: Cambiar el color primario de los botones */
.block_wpnews .wpnews-readmore {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
}

/* Ejemplo: Hacer las imágenes circulares */
.block_wpnews .wpnews-image {
    border-radius: 50%;
    width: 200px;
    height: 200px;
    margin: 0 auto;
}

/* Ejemplo: Cambiar el espaciado del grid */
.block_wpnews .wpnews-grid {
    gap: 2rem;
}

/* Ejemplo: Cards con efecto de vidrio (glassmorphism) */
.block_wpnews .wpnews-item {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
```

### Opción 2: Modificar el Archivo CSS

Editar directamente: `blocks/wpnews/styles_remui.css`

### Opción 3: Usar RemUI Theme Designer

Si RemUI tiene un Theme Designer/Customizer:

1. **Appearance > Theme Designer**
2. Ajustar colores primarios
3. El bloque heredará automáticamente esos colores

## 🎯 Configuraciones Recomendadas para RemUI

### Para el Home Page (Diseño Impactante)

```
Layout: Grid
Posts: 3 o 6
Show Image: ✓
Image Size: Large
Show Excerpt: ✓
Show Date: ✓
Show Categories: ✓
```

### Para Sidebar (Diseño Compacto)

```
Layout: List
Posts: 3
Show Image: ✓
Image Size: Thumbnail
Show Excerpt: ✗
Show Date: ✓
Show Categories: ✗
```

### Para Dashboard (Diseño Balanceado)

```
Layout: Grid
Posts: 4
Show Image: ✓
Image Size: Medium
Show Excerpt: ✓
Show Date: ✓
Show Categories: ✓
```

## 🔧 Crear un Widget para Edwiser Page Builder (Avanzado)

Si quieres que aparezca en el Page Builder, necesitas crear un **widget personalizado de Edwiser**.

### Pasos Generales:

1. **Crear un nuevo plugin de tipo local**
   - Tipo: `local_wpnews_widget`

2. **Registrar el widget con Edwiser**
   - Usar el API de Edwiser Form Builder
   - Crear archivo de definición del widget

3. **Ejemplo de estructura** (conceptual):

```php
// local/wpnews_widget/classes/widgets/wpnews.php
namespace local_wpnews_widget\widgets;

class wpnews extends \theme_remui\widgets\abstract_widget {

    public function get_name() {
        return 'wpnews';
    }

    public function get_title() {
        return get_string('wpnews', 'block_wpnews');
    }

    public function get_icon() {
        return 'fa fa-newspaper-o';
    }

    public function get_content($settings) {
        // Renderizar el contenido del bloque
        $block = new \block_wpnews();
        return $block->get_content();
    }
}
```

**Nota**: Esto requiere acceso al código fuente de RemUI y conocimiento del API de widgets de Edwiser, que es propietario.

## 📱 Diseños Responsivos

El bloque es completamente responsive:

### Desktop (> 1200px)
- Grid: 3 columnas
- Imágenes grandes
- Spacing amplio

### Tablet (768px - 1199px)
- Grid: 2-3 columnas
- Imágenes medianas
- Spacing medio

### Móvil (< 768px)
- Grid: 1 columna
- Imágenes adaptadas
- Spacing compacto

## 🎨 Ejemplos de Personalización Visual

### Ejemplo 1: Estilo Card Elevado

```css
.block_wpnews .wpnews-item {
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: none;
}

.block_wpnews .wpnews-item:hover {
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
    transform: translateY(-8px) scale(1.02);
}
```

### Ejemplo 2: Estilo Flat Material

```css
.block_wpnews .wpnews-item {
    box-shadow: none;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
}

.block_wpnews .wpnews-item:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
```

### Ejemplo 3: Estilo Neumorfismo

```css
.block_wpnews .wpnews-item {
    background: #f0f0f0;
    box-shadow: 8px 8px 16px #d1d1d1, -8px -8px 16px #ffffff;
    border: none;
}

.block_wpnews .wpnews-item:hover {
    box-shadow: inset 8px 8px 16px #d1d1d1, inset -8px -8px 16px #ffffff;
}
```

## 🚀 Mejores Prácticas

### 1. **Posicionamiento**
- Usar en el home page para máximo impacto
- No sobrecargar con demasiados posts (3-6 es ideal)

### 2. **Imágenes**
- Asegurar que WordPress tenga imágenes destacadas
- Usar tamaño "Medium" o "Large" para mejor calidad
- Imágenes optimizadas (< 200KB)

### 3. **Performance**
- Cache de 30-60 minutos es ideal
- No mostrar más de 6 posts simultáneamente
- Optimizar imágenes en WordPress

### 4. **Diseño**
- Grid para home page principal
- List para sidebars
- Mantener consistencia con el diseño de RemUI

## 🔍 Troubleshooting con RemUI

### El bloque no se ve bien

1. Limpiar cachés de Moodle
2. Verificar que RemUI esté actualizado
3. Revisar consola del navegador por errores CSS

### Los colores no coinciden con RemUI

```css
/* Forzar colores de RemUI */
.block_wpnews .wpnews-title:hover {
    color: var(--themecolor, #007bff) !important;
}

.block_wpnews .wpnews-readmore {
    background: var(--themecolor, #007bff) !important;
}
```

### El bloque aparece muy ancho o estrecho

Ajustar en RemUI:
- **Site administration > Appearance > Theme settings**
- Revisar configuración de columnas y regiones

## 📊 Comparación: Bloque vs Widget

| Característica | Bloque Tradicional | Widget Page Builder |
|----------------|-------------------|---------------------|
| Instalación | ✅ Plug & Play | ❌ Desarrollo adicional |
| Configuración | ✅ Por instancia | ✅ Por widget |
| Posicionamiento | ⚠️ Regiones limitadas | ✅ Anywhere |
| Mantenimiento | ✅ Fácil | ⚠️ Requiere updates |
| Compatibilidad | ✅ Universal | ⚠️ Solo RemUI |

## 🎓 Recursos Adicionales

- **Documentación RemUI**: https://remui.edwiser.org/documentation/
- **Edwiser Support**: https://edwiser.org/support/
- **Moodle Blocks**: https://docs.moodle.org/en/Blocks

## 💡 Conclusión

El bloque **WordPress News** está **completamente optimizado para RemUI** con:

✅ Estilos automáticos adaptados a RemUI
✅ Soporte para modo oscuro
✅ Diseño responsive perfecto
✅ Colores dinámicos según configuración de RemUI
✅ Performance optimizado

**No necesitas el Page Builder** para tener un diseño atractivo. El bloque se integra perfectamente con RemUI usando el sistema tradicional de bloques, y luce profesional y moderno.

Para un diseño **aún más personalizado**, usa las opciones de CSS personalizado de RemUI o modifica el archivo `styles_remui.css`.
