<?php

class CT_CtCarouselArrow_Widget extends Case_Theme_Core_Widget_Base{
    protected $name = 'ct_carousel_arrow';
    protected $title = 'Carousel Arrow';
    protected $icon = 'eicon-animation';
    protected $categories = array( 'case-theme-core' );
    protected $params = '{"sections":[{"name":"content_alignment_section","label":"Content Alignment","tab":"content","controls":[{"name":"style","label":"Style","type":"select","options":{"style1":"Style 1","style2":"Style 2","style3":"Style 3","style4":"Style 4"},"default":"style1"},{"name":"arrow_align","label":"Alignment","type":"choose","control_type":"responsive","options":{"start":{"title":"Left","icon":"fa fa-align-left"},"center":{"title":"Center","icon":"fa fa-align-center"},"flex-end":{"title":"Right","icon":"fa fa-align-right"}},"selectors":{"{{WRAPPER}} .ct-nav-carousel":"justify-content: {{VALUE}};"}},{"name":"class","label":"Class","type":"text","label_block":true}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}