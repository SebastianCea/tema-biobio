console.log("Fase 1: Script cargando (Versión 4 Efectos)...");

const addFilter = window.wp.hooks.addFilter;
const createHigherOrderComponent = window.wp.compose.createHigherOrderComponent;
const el = window.wp.element.createElement;
const Fragment = window.wp.element.Fragment;

const InspectorControls = window.wp.blockEditor ? window.wp.blockEditor.InspectorControls : window.wp.editor.InspectorControls;
const PanelBody = window.wp.components.PanelBody;
const ToggleControl = window.wp.components.ToggleControl;

// 1. Registro de atributos (Con Sepia incluido)
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

// 2. Interfaz Visual (El Panel y los 4 Botones)
const agregarControlesVisuales = createHigherOrderComponent(function(BlockEdit) {
    return function(props) {
        if (props.name !== 'core/image') {
            return el(BlockEdit, props);
        }

        return el(
            Fragment,
            null,
            el(BlockEdit, props),
            el(
                InspectorControls,
                null,
                el(
                    PanelBody,
                    { title: '🎨 Efectos BioBio', initialOpen: true },
                    
                    // Botón 1: Zoom
                    el(ToggleControl, {
                        label: 'Efecto Zoom al pasar cursor',
                        checked: !!props.attributes.efectoZoom,
                        onChange: function(val) { props.setAttributes({ efectoZoom: val }); }
                    }),
                    
                    // Botón 2: Blanco y Negro
                    el(ToggleControl, {
                        label: 'Filtro: Blanco y Negro',
                        checked: !!props.attributes.efectoByn,
                        onChange: function(val) { props.setAttributes({ efectoByn: val }); }
                    }),

                    // Botón 3: Sepia (Inyectado con coma correcta al final)
                    el(ToggleControl, {
                        label: 'Filtro: Sepia',
                        checked: !!props.attributes.efectoSepia,
                        onChange: function(val) { props.setAttributes({ efectoSepia: val }); }
                    }),
                    
                    // Botón 4: Esquinas
                    el(ToggleControl, {
                        label: 'Bordes Redondeados',
                        checked: !!props.attributes.fotoEsquinas,
                        onChange: function(val) { props.setAttributes({ fotoEsquinas: val }); }
                    })
                )
            )
        );
    };
}, 'agregarControlesVisuales');

addFilter('editor.BlockEdit', 'biobio/panel-imagen', agregarControlesVisuales);

// 3. Inyección de las clases CSS en el HTML público
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