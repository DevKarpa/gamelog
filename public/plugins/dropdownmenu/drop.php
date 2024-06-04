<?php if(isset($_SESSION["user"])){ ?>
                  <script>
                  tippy("#dropdown", {
                    content: '<ul class="drop"><li><a href="/profile/<?php echo $_SESSION["user"]["userID"] ?>?page=1&order=0&status=4">Mi perfil</a></li><li><a href="/logout">Cerrar sesión</a></li></ul>',
                    allowHTML: true,
                    trigger: 'click',
                    interactive: true,
                    placement: 'bottom'
                }); 
                  </script>
            <?php } ?>