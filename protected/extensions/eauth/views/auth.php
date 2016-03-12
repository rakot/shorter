<div class="services">
  <ul class="auth-services w10000 clear">
      <?php
        foreach ($services as $name => $service) {
            echo '<li class="auth-service '.$service->id.'">';
            $html = '<span class="auth-icon '.$service->id.'"><i></i></span>';
            $name_link = '<span class="auth-title">'.$service->title.'</span>';
            $html = CHtml::link($html, array($action, 'service' => $name), array(
                'class' => 'auth-link icon '.$service->id,
            ));
            echo $html;
            echo CHtml::link($name_link, array($action, 'service' => $name), array(
                'class' => 'auth-link name '.$service->id,
            ));
            echo '</li>';
        }
      ?>
      <br class="clr" />
  </ul>
</div>