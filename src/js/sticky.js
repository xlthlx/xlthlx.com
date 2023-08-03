/**
 * Main theme object.
 */
const Xlt_Sticky = function () {

    const self = this;

    this.sticky_fix = function () {

        const elements = document.querySelectorAll('.xlt-sticky');
        const sticky_parent = Array.prototype.slice.call(elements);

        sticky_parent.forEach(function (value, index) {
            let sticky_top = sticky_parent[index].getElementsByClassName('xlt-sticky_top'),
                sticky_bottom = sticky_parent[index].getElementsByClassName('xlt-sticky_bottom');
            sticky_bottom.marginTop = sticky_top.offsetHeight;
        })

    }

    /**
     * Sticky check
     */
    this.sticky = function () {
        if (document.getElementsByClassName('xlt-sticky').length === 0) {
            return false;
        }
    };

    /**
     * Event binding.
     */
    this.bind = function () {
        self.sticky();
    };

    /**
     * Initialization.
     */
    this.init = function () {
        self.bind();

        window.addEventListener('resize', function () {
            self.sticky_fix();
        });
    };

    this.init();

};

(new Xlt_Sticky());