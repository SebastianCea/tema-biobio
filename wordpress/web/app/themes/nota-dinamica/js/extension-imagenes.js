console.log("Fase 1: Script cargando (Versión 4 Efectos)...");

const addFilter = window.wp.hooks.addFilter;
const createHigherOrderComponent = window.wp.compose.createHigherOrderComponent;
const el = window.wp.element.createElement;
const Fragment = window.wp.element.Fragment;

const InspectorControls = window.wp.blockEditor ? window.wp.blockEditor.InspectorControls : window.wp.editor.InspectorControls;
const PanelBody = window.wp.components.PanelBody;
const ToggleControl = window.wp.components.ToggleControl;

// 1. Registro de atributos
addFilter('blocks.registerBlockType', 'biobio/atributos-imagen', function(settings, name) {
    if (name === 'core/image') {
        settings.attributes = Object.assign({}, settings.attributes, {
            efectoZoom: { type: 'boolean', default: false },
            efectoByn: { type: 'boolean', default: false },
            efectoSepia: { type: 'boolean', default: false },
            fotoEsquinas: { type: 'boolean', default: false }
        });
    }
    return settings;
});

// 2. Interfaz Visual (La función corregida y única)
const agregarControlesVisuales = createHigherOrderComponent(function(BlockEdit) {
    return function(props) {
        // Solo actuar sobre bloques de imagen
        if (props.name !== 'core/image') {
            return el(BlockEdit, props);
        }

        // 1. Calcular las clases basándonos en los atributos actuales
        const { efectoZoom, efectoByn, efectoSepia, fotoEsquinas } = props.attributes;
        let nuevasClases = props.attributes.className || ''; 
        
        if (efectoZoom) nuevasClases += ' efecto-zoom';
        if (efectoByn) nuevasClases += ' filtro-byn';
        if (efectoSepia) nuevasClases += ' filtro-sepia';
        if (fotoEsquinas) nuevasClases += ' foto-esquinas';

        // 2. Renderizar el bloque con las clases inyectadas
        return el(
            Fragment,
            null,
            // Pasamos className para que el editor pinte los cambios en tiempo real
            el(BlockEdit, { ...props, className: nuevasClases.trim() }), 
            el(
                InspectorControls,
                null,
                el(
                    PanelBody,
                    { title: '🎨 Efectos BioBio', initialOpen: true },
                    el(ToggleControl, {
                        label: 'Efecto Zoom',
                        checked: !!efectoZoom,
                        onChange: function(val) { props.setAttributes({ efectoZoom: val }); }
                    }),
                    el(ToggleControl, {
                        label: 'Blanco y Negro',
                        checked: !!efectoByn,
                        onChange: function(val) { props.setAttributes({ efectoByn: val }); }
                    }),
                    el(ToggleControl, {
                        label: 'Filtro Sepia',
                        checked: !!efectoSepia,
                        onChange: function(val) { props.setAttributes({ efectoSepia: val }); }
                    }),
                    el(ToggleControl, {
                        label: 'Bordes Redondeados',
                        checked: !!fotoEsquinas,
                        onChange: function(val) { props.setAttributes({ fotoEsquinas: val }); }
                    })
                )
            )
        );
    };
}, 'agregarControlesVisuales');

addFilter('editor.BlockEdit', 'biobio/panel-imagen', agregarControlesVisuales);

// 3. Inyección de las clases CSS en el HTML público (Frontend)
addFilter('blocks.getSaveContent.extraProps', 'biobio/inyectar-clases-imagen', function(extraProps, blockType, attributes) {
    if (blockType.name === 'core/image') {
        let clases = extraProps.className || '';
        
        if (attributes.efectoZoom) clases += ' efecto-zoom';
        if (attributes.efectoByn) clases += ' filtro-byn';
        if (attributes.efectoSepia) clases += ' filtro-sepia';
        if (attributes.fotoEsquinas) clases += ' foto-esquinas';
        
        extraProps.className = clases.trim();
    }
    return extraProps;
});