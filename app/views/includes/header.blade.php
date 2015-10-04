<header>
    <div class="container h-center">
        <div class="row">
            <div class="col-10 h-center f-none">
                <div class="logo pull-left">
                    <a href='{{$root}}'><svg width='22' height='24'><use xlink:href="#logo"></use></svg> COBOO</a>
                </div>
                <div class="pull-right profile">
                    <?php $logged=true; if($logged){ ?>
                        <a href="#">Login here<svg width="28" height="28" ><use xlink:href="#user"></use></svg></a>
                    <?php }else{ ?>
                        <a href="{{$root}}/bag" class="bag">0</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="svg-lib">
    @include('includes.svg-lib')
</div>
<div id="body_compensator"></div>
<!-- ---------------------END OF HEADER------------------------ -->

<div class="container h-center">