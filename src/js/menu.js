/**
 * Main theme object.
 */
const Xlt_Menu = function () {

    let self = this,
        menuTrap = false;

    this.menuPanelSpacing = function () {
        const trigger = document.querySelector('.xlt-h-nav__trigger');

        if (trigger.length !== 0) {
            document.querySelector('.xlt-nav').style.paddingTop = trigger.offsetTop + trigger.offsetHeight;
        }
    }

    /**
     * Menu panel.
     */
    this.menuPanel = function () {

        self.menuPanelSpacing();

        document.querySelector('.xlt-h-nav__trigger').onclick = function () {

            menuTrap = !menuTrap;
            document.body.classList.toggle('xlt-h-nav_open');
        }
    }

    /**
     * Bind focus on menu items.
     */
    this.bindMenuItems = function () {

        document.querySelector('.xlt-h-nav__trigger, .xlt-nav .menu a').onblur = function () {
            if (menuTrap === true) {
                this.focus();
            }
        }
    }

    /**
     * Event binding.
     */
    this.bind = function () {
        self.menuPanel();
        self.bindMenuItems();
    };

    /**
     * Initialization.
     */
    this.init = function () {
        self.bind();
        window.addEventListener('resize', function () {
            self.menuPanelSpacing();
        });

    };

    this.init();

};

(new Xlt_Menu());