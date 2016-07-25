<header>
    <div class="container h-center">
        <div class="row">
            <div class="col-12 h-center f-none">
                <div class="logo pull-left">
                    <a href='{{$root}}'><svg width='22' height='24'><use xlink:href="#logo"></use></svg> COBOO</a>
                </div>
                <div class="pull-right profile">
                    <?php if(!$logged){ ?>
                        <a href="#" class="md-trigger" data-modal="modal-1">Login here<svg width="28" height="28" ><use xlink:href="#user"></use></svg></a>
                    <?php } else{ ?>
                        Hi <?php echo $name;?> &nbsp; <a href="{{$root}}/bag" class="bag" title="Cart"></a> &nbsp;<a href="{{$root}}/orders" class="cart" title="My Orders">My Orders</a> &nbsp; <a href="{{$root}}/logout">Logout</a>
                    <?php } ?>
                </div>
                <div class="clear"></div>
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