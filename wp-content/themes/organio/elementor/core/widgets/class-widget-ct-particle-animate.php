<?php

class CT_CtParticleAnimate_Widget extends Case_Theme_Core_Widget_Base{
    protected $name = 'ct_particle_animate';
    protected $title = 'Particle Animate';
    protected $icon = 'eicon-barcode';
    protected $categories = array( 'case-theme-core' );
    protected $params = '{"sections":[{"name":"content_section","label":"Source Settings","tab":"content","controls":[{"name":"content_list","label":"Images","type":"repeater","default":[],"controls":[{"name":"particle","label":"Particle","type":"media"},{"name":"particle_animate","label":"Animate","type":"select","options":{"animate-none":"None","shape-parallax":"Parallax","shape-animate1":"Animate 1","shape-animate2":"Animate 2","shape-animate3":"Animate 3","shape-animate4":"Animate 4"},"default":"animate-none"},{"name":"type_position","label":"Position","type":"select","options":{"top-left":"Top Left","top-right":"Top Right","bottom-right":"Bottom Right"},"default":"top-left"},{"name":"top_positioon","label":"Top Position","type":"slider","size_units":["px","%"],"default":{"size":0,"unit":"%"},"range":{"%":{"min":0,"max":100}},"condition":{"type_position":["top-left","top-right"]}},{"name":"left_positioon","label":"Left Position","type":"slider","size_units":["px","%"],"default":{"size":0,"unit":"%"},"range":{"%":{"min":0,"max":100}},"condition":{"type_position":"top-left"}},{"name":"bottom_positioon","label":"Bottom Position","type":"slider","size_units":["px","%"],"default":{"size":0,"unit":"%"},"range":{"%":{"min":0,"max":100}},"condition":{"type_position":["bottom-right"]}},{"name":"right_positioon","label":"Right Position","type":"slider","size_units":["px","%"],"default":{"size":0,"unit":"%"},"range":{"%":{"min":0,"max":100}},"condition":{"type_position":["top-right","bottom-right"]}}]}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}