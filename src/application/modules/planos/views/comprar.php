<div class="pcoded-content">

    <?php if(isset($message)) echo $message; ?>
    
    <div style="display: flex; justify-content: center; align-items: center; margin: 50px 0;">
        <!-- Slider main container -->
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php
                if($planos !== false){
                    foreach($planos as $k=>$plano){
                ?>
                <div class="swiper-slide bgColor-nft">
                    <div class="picture bgColor-nft">
                        <img src="<?php echo base_url();?>/assets/icons_plans/<?php echo ($k+1);?>.png" alt="">
                    </div>
                    <div class="detail font-decorative">
                        <h2 class="font-decorative text-capitalize text-color-nft"><?php echo strtoupper($plano->nome);?></h2>
                        <h4 class="p-2 text-white"><?php echo MOEDA;?> <?php echo number_format($plano->valor, 2, ',', '.');?> <br> <small>
                        <?php
                        $decodePercents = json_decode($plano->percentual_pago, true);
                        $last = end($decodePercents);
                        echo $last;
                        ?>
                        % / <?php echo $plano->quantidade_dias;?> dias</small></h4>
                        <h5 class="text-white pb-3"><small>
                        <?php
                        $decodeNiveis = json_decode($plano->niveis_indicacao, true);
                        $nivel = array_key_last($decodeNiveis);
                        echo sprintf($this->lang->line('plan_form_indicacao_ate'), $nivel);
                        ?>
                        </small></h5>
                        <form action="" method="post">
                            <button type="submit" name="submit" value="submit" class="btn btn-light btn-lg btn-block text-lowercase mb-4">Comprar agora</button>
                            <input type="hidden" name="id_plano" value="<?php echo $plano->id;?>" />
                            <input type="hidden" name="<?php echo $csrfName;?>" value="<?php echo $csrfHash;?>" />
                        </form>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
                <!-- <div class="swiper-button-prev"></div> -->
                <!-- <div class="swiper-button-next"></div> -->

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>
        </div>
    </div>
</div>