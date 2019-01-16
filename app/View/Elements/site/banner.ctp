<?php
/**
 * @copyright Copyright 2018 
 * @author Paulo Mendes
 * Banner Element View
 */
?>
<div class="container">
    <?php
    $pathBanner = Configure::read('Directory.Banner');
    $imageBanner = '';

    foreach ( $banners as $banner ):
        $imageBanner = $banner['Banner'];
    endforeach;
    
    $optionsImage = [
        'title' => $imageBanner['name'],
        'alt' => $imageBanner['name'],
        'class' => 'img-responsive'
    ];

    if(empty($imageBanner['url'])){

        echo $this->Html->image("/files/banner/image/{$imageBanner['id']}/vga_{$imageBanner['image']}", $optionsImage);

    }else{
        
        $optionsLink = ['escape'=>false];

        if (!empty($imageBanner['target']))
            $optionsLink['target'] = '_blank';

        echo $this->Html->link(
            $this->Html->image("/files/banner/image/{$imageBanner['id']}/vga_{$imageBanner['image']}", $optionsImage),
            $imageBanner['url'],
            $optionsLink
        );
    }
    ?>
</div>