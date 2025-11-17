# Guía de Migración a Moodle 5.0

Este documento explica la compatibilidad del plugin **WordPress News** con Moodle 5.0 y cómo migrar desde Moodle 4.5.

## ✅ Estado de Compatibilidad

El plugin **WordPress News v1.2.0+** está **100% preparado y compatible** con Moodle 5.0.

### Versiones Soportadas

- ✅ **Moodle 4.5** (Bootstrap 4)
- ✅ **Moodle 5.0** (Bootstrap 5)
- ✅ **PHP 8.0+** (recomendado PHP 8.1+ para Moodle 5)

### Compatibilidad Verificada

| Característica | Moodle 4.5 | Moodle 5.0 | Notas |
|---------------|------------|------------|-------|
| Core Plugin | ✅ | ✅ | Totalmente compatible |
| WordPress API Client | ✅ | ✅ | Sin cambios necesarios |
| Cache System | ✅ | ✅ | MUC compatible |
| Templates Mustache | ✅ | ✅ | Sin cambios |
| Bootstrap 4 Styles | ✅ | ⚠️ | Funciona pero legacy |
| Bootstrap 5 Styles | ⚠️ | ✅ | Auto-cargado en Moodle 5 |
| RemUI Theme | ✅ | ✅ | Compatible ambas versiones |
| Dark Mode | ✅ | ✅ | Mejorado en Moodle 5 |
| Capabilities | ✅ | ✅ | Sin cambios |
| Privacy API | ✅ | ✅ | Sin cambios |

## 🚀 Cambios Principales en Moodle 5

### 1. Bootstrap 5 (desde Bootstrap 4)

**Cambios Clave:**
- `badge-pill` → `rounded-pill`
- `badge-primary` → `bg-primary`
- `ml-*` / `mr-*` → `ms-*` / `me-*` (start/end en lugar de left/right)
- `pr-*` / `pl-*` → `pe-*` / `ps-*`

**Solución del Plugin:**
El plugin detecta automáticamente la versión de Moodle y carga los estilos apropiados:
- **Moodle 4.5**: Usa `styles.css` (Bootstrap 4)
- **Moodle 5.0**: Usa `styles_bs5.css` (Bootstrap 5)

### 2. PHP 8.1+ Requerido

Moodle 5.0 requiere **PHP 8.1 como mínimo** (actualmente el plugin funciona con PHP 8.0+).

**Recomendación:**
Actualizar a PHP 8.1+ antes de migrar a Moodle 5.

### 3. APIs Deprecadas Removidas

El plugin **NO usa APIs deprecadas**, por lo que no hay problemas de compatibilidad.

## 📋 Lista de Verificación Pre-Migración

Antes de actualizar a Moodle 5, verifica:

- [ ] **PHP 8.1+** instalado en el servidor
- [ ] **Plugin actualizado** a v1.2.0 o superior
- [ ] **Backup completo** de Moodle y base de datos
- [ ] **Caché limpiado** después de la actualización
- [ ] **WordPress API** funcionando correctamente
- [ ] **Permisos de archivos** correctos

## 🔄 Proceso de Migración

### Opción 1: Migración Directa (Recomendado)

1. **Actualizar el plugin a v1.2.0**
   ```bash
   cd /path/to/moodle
   # Hacer backup del plugin actual
   cp -r blocks/wpnews blocks/wpnews.backup

   # Actualizar archivos del plugin
   git pull origin main
   # o copiar manualmente la versión 1.2.0
   ```

2. **Actualizar Moodle a 5.0**
   - Seguir la [guía oficial de actualización de Moodle](https://docs.moodle.org/en/Upgrading)
   - Ejecutar el proceso de upgrade
   - Limpiar cachés

3. **Verificar el plugin**
   - Ir a **Site administration > Plugins > Plugins overview**
   - Verificar que **WordPress News** muestra v1.2.0
   - Verificar que no hay errores

4. **Probar funcionalidad**
   - Crear un bloque de prueba
   - Verificar que se muestran las noticias
   - Verificar estilos Bootstrap 5

### Opción 2: Instalación Limpia

Si prefieres una instalación limpia en Moodle 5:

1. **En Moodle 4.5**: Exportar configuraciones (anota las URLs de WordPress usadas)
2. **Actualizar a Moodle 5.0**
3. **Instalar plugin v1.2.0** en Moodle 5
4. **Reconfigurar bloques** con las URLs guardadas

## 🎨 Cambios Visuales en Moodle 5

### Bootstrap 5 Mejoras

El plugin en Moodle 5 incluye:

✨ **Mejoras visuales:**
- Bordes más redondeados (0.75rem vs 0.5rem)
- Sombras más suaves y naturales
- Mejor soporte para variables CSS
- Transiciones más fluidas

✨ **Dark mode mejorado:**
- Uso de `data-bs-theme="dark"` (Bootstrap 5 nativo)
- Mejor detección automática
- Colores más consistentes

✨ **Accesibilidad:**
- `focus-visible` en lugar de `focus`
- Mejor contraste de colores
- Soporte mejorado para lectores de pantalla

### Comparación Visual

```css
/* Moodle 4.5 (Bootstrap 4) */
.badge-pill.badge-primary

/* Moodle 5.0 (Bootstrap 5) */
.rounded-pill.bg-primary
```

**Resultado visual:** Idéntico, solo cambian las clases CSS internas.

## 🔧 Resolución de Problemas

### Problema: Estilos se ven rotos después de migrar

**Síntomas:**
- Badges sin forma de píldora
- Espaciados incorrectos
- Colores no aplicados

**Solución:**
```bash
# 1. Limpiar cachés de Moodle
php admin/cli/purge_caches.php

# 2. Verificar que se carga styles_bs5.css
# En navegador: Ver código fuente → buscar "styles_bs5.css"

# 3. Limpiar caché del navegador
# Ctrl+Shift+Delete o Cmd+Shift+Delete
```

### Problema: Plugin no detecta Moodle 5

**Verificación:**
```php
// Agregar temporalmente al inicio de block_wpnews.php
global $CFG;
error_log('Moodle version: ' . $CFG->version);
error_log('Is Moodle 5: ' . ($CFG->version >= 2024100100 ? 'YES' : 'NO'));
```

**Solución:**
Verificar que `version.php` tiene:
```php
$plugin->version = 2024111702; // o superior
$plugin->supported = [405, 500];
```

### Problema: WordPress API no funciona después de migrar

**Causa:** No relacionada con Moodle 5, el API cliente es idéntico.

**Solución:**
1. Verificar conectividad: `curl https://tu-wordpress.com/wp-json/wp/v2/posts`
2. Revisar logs de PHP: `/var/log/php/error.log`
3. Verificar timeout en configuración

## 📊 Testing Checklist

Después de migrar a Moodle 5, verifica:

### Funcionalidad
- [ ] El bloque se puede añadir a páginas
- [ ] Las noticias se cargan desde WordPress
- [ ] Las imágenes se muestran correctamente
- [ ] Los enlaces funcionan
- [ ] El caché funciona (verificar tiempos de carga)

### Estilos
- [ ] Cards se ven correctamente
- [ ] Badges tienen forma de píldora
- [ ] Espaciados son correctos
- [ ] Hover effects funcionan
- [ ] Responsive funciona (móvil, tablet, desktop)

### Configuración
- [ ] Formulario de configuración funciona
- [ ] Validación de URLs funciona
- [ ] Autenticación funciona (si se usa)
- [ ] Configuración global accesible

### Rendimiento
- [ ] Caché funciona correctamente
- [ ] No hay errores en consola del navegador
- [ ] No hay errores en logs de PHP
- [ ] Tiempo de carga aceptable

## 📈 Ventajas de Moodle 5

### Para el Plugin

1. **Mejor rendimiento**
   - Bootstrap 5 es más ligero
   - Menos dependencias CSS

2. **Mejor accesibilidad**
   - Mejores estándares ARIA
   - Mejor soporte para tecnologías asistivas

3. **Mejor dark mode**
   - Detección nativa de Bootstrap 5
   - Variables CSS más consistentes

4. **Código más limpio**
   - Uso de variables CSS nativas
   - Menos hacks para compatibilidad

## 🔮 Futuro del Plugin

### Roadmap

- **v1.2.x**: Mantenimiento y bug fixes para Moodle 4.5 y 5.0
- **v1.3.0**: Eliminar soporte para Moodle 4.4 y anteriores
- **v2.0.0**: Requiere Moodle 5.0+ como mínimo (futuro)

### Deprecation Schedule

- **Moodle 4.4 y anteriores**: Ya no soportados
- **Moodle 4.5**: Soportado hasta Moodle 5.2
- **Bootstrap 4**: Soportado hasta v1.5.0

## 📚 Recursos Adicionales

### Documentación Oficial

- [Moodle 5.0 Release Notes](https://docs.moodle.org/dev/Moodle_5.0_release_notes)
- [Moodle Upgrade Guide](https://docs.moodle.org/en/Upgrading)
- [Bootstrap 5 Migration Guide](https://getbootstrap.com/docs/5.0/migration/)

### Plugin Específico

- [README.md](README.md) - Documentación principal
- [REMUI_INTEGRATION.md](REMUI_INTEGRATION.md) - Integración con RemUI

## ❓ FAQ

### ¿Necesito hacer algo especial para migrar?

**No.** El plugin detecta automáticamente la versión de Moodle y carga los estilos apropiados.

### ¿Puedo usar v1.2.0 en Moodle 4.5?

**Sí.** La versión 1.2.0 es compatible con Moodle 4.5 y 5.0.

### ¿Qué pasa con RemUI en Moodle 5?

**RemUI funciona perfectamente.** El plugin sigue detectando RemUI y cargando estilos específicos.

### ¿Afecta al rendimiento la detección de versión?

**No.** La detección se hace una sola vez al renderizar el bloque, el impacto es mínimo.

### ¿Necesito reconfigurar mis bloques?

**No.** Toda la configuración se mantiene al migrar.

## 🎓 Conclusión

El plugin **WordPress News v1.2.0** está **completamente preparado** para Moodle 5.0:

✅ **Zero configuración** - Funciona automáticamente
✅ **Zero cambios** - No necesitas reconfigurar
✅ **Zero downtime** - Migración transparente
✅ **Mejor experiencia** - Aprovecha Bootstrap 5

**Recomendación:** Actualiza a v1.2.0 antes de migrar a Moodle 5 para una transición suave.

---

**Última actualización:** 2024-11-17
**Versión del plugin:** 1.2.0
**Versiones soportadas:** Moodle 4.5 - 5.0
