<?php

namespace App\Menus;


class Starter implements MenuInterface
{

    public function getMenu()
    {
        return [
            array(
                'title' => 'Intro',
                'url' => 'home/index',
                'icon' => 'feather icon-alert-octagon',
            ),
            [
                'title' => 'Sample CRUD',
                'class' => 'navigation-header',
            ],
            array(
                'title' => 'Alumni',
                'url' => 'alumni',
                'icon' => 'feather icon-users',
            ),
            [
                'title' => 'Sample Template',
                'class' => 'navigation-header',
            ],
            [
                'title' => 'Dashboard', 'icon' => 'feather icon-home', 'url' => '#',
                'children' => [
                    ['title' => 'Analytics', 'url' => 'sampleTheme/view/dashboard-analytics'],
                    ['title' => 'eCommerce', 'url' => 'sampleTheme/view/dashboard-ecommerce'],
                ]
            ],
            [
                'title' => 'Apps',
                'class' => 'navigation-header',
            ],
            array(
                'title' => 'Email',
                'url' => 'sampleTheme/view/app-email',
                'icon' => 'feather icon-mail',
            ),
            array(
                'title' => 'Chat',
                'url' => 'sampleTheme/view/app-chat',
                'icon' => 'feather icon-message-square',
            ),
            array(
                'title' => 'Todo',
                'url' => 'sampleTheme/view/app-todo',
                'icon' => 'feather icon-check-square',
            ),
            array(
                'title' => 'Calender',
                'url' => 'sampleTheme/view/app-calender',
                'icon' => 'feather icon-calendar',
            ),
            array(
                'title' => 'Ecommerce',
                'url' => '#',
                'icon' => 'feather icon-shopping-cart',
                'children' =>
                array(
                    array(
                        'title' => 'Shop',
                        'url' => 'sampleTheme/view/app-ecommerce-shop',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Details',
                        'url' => 'sampleTheme/view/app-ecommerce-details',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Wish List',
                        'url' => 'sampleTheme/view/app-ecommerce-wishlist',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Checkout',
                        'url' => 'sampleTheme/view/app-ecommerce-checkout',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'User',
                'url' => '#',
                'icon' => 'feather icon-user',
                'children' =>
                array(
                    array(
                        'title' => 'List',
                        'url' => 'sampleTheme/view/app-user-list',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'View',
                        'url' => 'sampleTheme/view/app-user-view',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Edit',
                        'url' => 'sampleTheme/view/app-user-edit',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'UI Elements',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Data List',
                'url' => '#',
                'icon' => 'feather icon-list',
                'children' =>
                array(
                    array(
                        'title' => 'List View',
                        'url' => 'sampleTheme/view/data-list-view',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Thumb View',
                        'url' => 'sampleTheme/view/data-thumb-view',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Content',
                'url' => '#',
                'icon' => 'feather icon-layout',
                'children' =>
                array(
                    array(
                        'title' => 'Grid',
                        'url' => 'sampleTheme/view/content-grid',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Typography',
                        'url' => 'sampleTheme/view/content-typography',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Text Utilities',
                        'url' => 'sampleTheme/view/content-text-utilities',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Syntax Highlighter',
                        'url' => 'sampleTheme/view/content-syntax-highlighter',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Helper Classes',
                        'url' => 'sampleTheme/view/content-helper-classes',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Colors',
                'url' => 'sampleTheme/view/colors',
                'icon' => 'feather icon-droplet',
            ),
            array(
                'title' => 'Icons',
                'url' => '#',
                'icon' => 'feather icon-eye',
                'children' =>
                array(
                    array(
                        'title' => 'Feather',
                        'url' => 'sampleTheme/view/icons-feather',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Font Awesome',
                        'url' => 'sampleTheme/view/icons-font-awesome',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Card',
                'url' => '#',
                'icon' => 'feather icon-credit-card',
                'children' =>
                array(
                    array(
                        'title' => 'Basic',
                        'url' => 'sampleTheme/view/card-basic',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Advance',
                        'url' => 'sampleTheme/view/card-advance',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Statistics',
                        'url' => 'sampleTheme/view/card-statistics',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Analytics',
                        'url' => 'sampleTheme/view/card-analytics',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Card Actions',
                        'url' => 'sampleTheme/view/card-actions',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Components',
                'url' => '#',
                'icon' => 'feather icon-briefcase',
                'children' =>
                array(
                    array(
                        'title' => 'Alerts',
                        'url' => 'sampleTheme/view/component-alerts',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Buttons',
                        'url' => 'sampleTheme/view/component-buttons-basic',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Breadcrumbs',
                        'url' => 'sampleTheme/view/component-breadcrumbs',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Carousel',
                        'url' => 'sampleTheme/view/component-carousel',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Collapse',
                        'url' => 'sampleTheme/view/component-collapse',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Dropdowns',
                        'url' => 'sampleTheme/view/component-dropdowns',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'List Group',
                        'url' => 'sampleTheme/view/component-list-group',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Modals',
                        'url' => 'sampleTheme/view/component-modals',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Pagination',
                        'url' => 'sampleTheme/view/component-pagination',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Navs Component',
                        'url' => 'sampleTheme/view/component-navs-component',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Navbar',
                        'url' => 'sampleTheme/view/component-navbar',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Tabs Component',
                        'url' => 'sampleTheme/view/component-tabs-component',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Pills Component',
                        'url' => 'sampleTheme/view/component-pills-component',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Tooltips',
                        'url' => 'sampleTheme/view/component-tooltips',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Popovers',
                        'url' => 'sampleTheme/view/component-popovers',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Badges',
                        'url' => 'sampleTheme/view/component-badges',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Pill Badges',
                        'url' => 'sampleTheme/view/component-pill-badges',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Progress',
                        'url' => 'sampleTheme/view/component-progress',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Media Objects',
                        'url' => 'sampleTheme/view/component-media-objects',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Spinner',
                        'url' => 'sampleTheme/view/component-spinner',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Toasts',
                        'url' => 'sampleTheme/view/component-bs-toast',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Extra Components',
                'url' => '#',
                'icon' => 'feather icon-box',
                'children' =>
                array(
                    array(
                        'title' => 'Avatar',
                        'url' => 'sampleTheme/view/ex-component-avatar',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Chips',
                        'url' => 'sampleTheme/view/ex-component-chips',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Divider',
                        'url' => 'sampleTheme/view/ex-component-divider',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Forms & Tables',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Form Elements',
                'url' => '#',
                'icon' => 'feather icon-copy',
                'children' =>
                array(
                    array(
                        'title' => 'Select',
                        'url' => 'sampleTheme/view/form-select',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Switch',
                        'url' => 'sampleTheme/view/form-switch',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Checkbox',
                        'url' => 'sampleTheme/view/form-checkbox',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Radio',
                        'url' => 'sampleTheme/view/form-radio',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Input',
                        'url' => 'sampleTheme/view/form-inputs',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Input Groups',
                        'url' => 'sampleTheme/view/form-input-groups',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Number Input',
                        'url' => 'sampleTheme/view/form-number-input',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Textarea',
                        'url' => 'sampleTheme/view/form-textarea',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Date & Time Picker',
                        'url' => 'sampleTheme/view/form-date-time-picker',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Form Layout',
                'url' => 'sampleTheme/view/form-layout',
                'icon' => 'feather icon-box',
            ),
            array(
                'title' => 'Form Wizard',
                'url' => 'sampleTheme/view/form-wizard',
                'icon' => 'feather icon-package',
            ),
            array(
                'title' => 'Form Validation',
                'url' => 'sampleTheme/view/form-validation',
                'icon' => 'feather icon-check-circle',
            ),
            array(
                'title' => 'Table',
                'url' => 'sampleTheme/view/table',
                'icon' => 'feather icon-server',
            ),
            array(
                'title' => 'Datatable',
                'url' => 'sampleTheme/view/table-datatable',
                'icon' => 'feather icon-grid',
            ),
            array(
                'title' => 'agGrid Table',
                'url' => 'sampleTheme/view/table-ag-grid',
                'icon' => 'feather icon-grid',
            ),
            array(
                'title' => 'Pages',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Profile',
                'url' => 'sampleTheme/view/page-user-profile',
                'icon' => 'feather icon-user',
            ),
            array(
                'title' => 'Account Settings',
                'url' => 'sampleTheme/view/page-account-settings',
                'icon' => 'feather icon-settings',
            ),
            array(
                'title' => 'FAQ',
                'url' => 'sampleTheme/view/page-faq',
                'icon' => 'feather icon-help-circle',
            ),
            array(
                'title' => 'Knowledge Base',
                'url' => 'sampleTheme/view/page-knowledge-base',
                'icon' => 'feather icon-info',
            ),
            array(
                'title' => 'Search',
                'url' => 'sampleTheme/view/page-search',
                'icon' => 'feather icon-search',
            ),
            array(
                'title' => 'Invoice',
                'url' => 'sampleTheme/view/page-invoice',
                'icon' => 'feather icon-file',
            ),
            array(
                'title' => 'Starter kit',
                'url' => '#',
                'icon' => 'feather icon-zap',
                'children' =>
                array(
                    array(
                        'title' => '2 columns',
                        'url' => 'sampleTheme/view/../../../starter-kit/ltr/vertical-menu-template/sk-layout-2-columns',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Fixed navbar',
                        'url' => 'sampleTheme/view/../../../starter-kit/ltr/vertical-menu-template/sk-layout-fixed-navbar',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Floating navbar',
                        'url' => 'sampleTheme/view/../../../starter-kit/ltr/vertical-menu-template/sk-layout-floating-navbar',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Fixed layout',
                        'url' => 'sampleTheme/view/../../../starter-kit/ltr/vertical-menu-template/sk-layout-fixed',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Authentication',
                'url' => '#',
                'icon' => 'feather icon-unlock',
                'children' =>
                array(
                    array(
                        'title' => 'Login',
                        'url' => 'sampleTheme/view/auth-login',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Register',
                        'url' => 'sampleTheme/view/auth-register',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Forgot Password',
                        'url' => 'sampleTheme/view/auth-forgot-password',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Reset Password',
                        'url' => 'sampleTheme/view/auth-reset-password',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Lock Screen',
                        'url' => 'sampleTheme/view/auth-lock-screen',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Miscellaneous',
                'url' => '#',
                'icon' => 'feather icon-file-text',
                'children' =>
                array(
                    array(
                        'title' => 'Coming Soon',
                        'url' => 'sampleTheme/view/page-coming-soon',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Error',
                        'url' => '#',
                        'icon' => 'feather icon-circle',
                        'children' =>
                        array(
                            array(
                                'title' => '404',
                                'url' => 'sampleTheme/view/error-404',
                                'icon' => 'feather icon-circle',
                            ),
                            array(
                                'title' => '500',
                                'url' => 'sampleTheme/view/error-500',
                                'icon' => 'feather icon-circle',
                            ),
                        ),
                    ),
                    array(
                        'title' => '404',
                        'url' => 'sampleTheme/view/error-404',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => '500',
                        'url' => 'sampleTheme/view/error-500',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Not Authorized',
                        'url' => 'sampleTheme/view/page-not-authorized',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Maintenance',
                        'url' => 'sampleTheme/view/page-maintenance',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Charts & Maps',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Charts',
                'url' => '#',
                'icon' => 'feather icon-pie-chart',
                'children' =>
                array(
                    array(
                        'title' => 'Apex',
                        'url' => 'sampleTheme/view/chart-apex',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Chartjs',
                        'url' => 'sampleTheme/view/chart-chartjs',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Echarts',
                        'url' => 'sampleTheme/view/chart-echarts',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Google Maps',
                'url' => 'sampleTheme/view/maps-google',
                'icon' => 'feather icon-map',
            ),
            array(
                'title' => 'Extensions',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Sweet Alert',
                'url' => 'sampleTheme/view/ext-component-sweet-alerts',
                'icon' => 'feather icon-alert-circle',
            ),
            array(
                'title' => 'Toastr',
                'url' => 'sampleTheme/view/ext-component-toastr',
                'icon' => 'feather icon-zap',
            ),
            array(
                'title' => 'NoUi Slider',
                'url' => 'sampleTheme/view/ext-component-noui-slider',
                'icon' => 'feather icon-sliders',
            ),
            array(
                'title' => 'File Uploader',
                'url' => 'sampleTheme/view/ext-component-file-uploader',
                'icon' => 'feather icon-upload-cloud',
            ),
            array(
                'title' => 'Quill Editor',
                'url' => 'sampleTheme/view/ext-component-quill-editor',
                'icon' => 'feather icon-edit',
            ),
            array(
                'title' => 'Drag & Drop',
                'url' => 'sampleTheme/view/ext-component-drag-drop',
                'icon' => 'feather icon-droplet',
            ),
            array(
                'title' => 'Tour',
                'url' => 'sampleTheme/view/ext-component-tour',
                'icon' => 'feather icon-info',
            ),
            array(
                'title' => 'Clipboard',
                'url' => 'sampleTheme/view/ext-component-clipboard',
                'icon' => 'feather icon-copy',
            ),
            array(
                'title' => 'Media player',
                'url' => 'sampleTheme/view/ext-component-plyr',
                'icon' => 'feather icon-film',
            ),
            array(
                'title' => 'Context Menu',
                'url' => 'sampleTheme/view/ext-component-context-menu',
                'icon' => 'feather icon-more-horizontal',
            ),
            array(
                'title' => 'swiper',
                'url' => 'sampleTheme/view/ext-component-swiper',
                'icon' => 'feather icon-smartphone',
            ),
            array(
                'title' => 'l18n',
                'url' => 'sampleTheme/view/ext-component-i18n',
                'icon' => 'feather icon-globe',
            ),
            array(
                'title' => 'Others',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Menu Levels',
                'url' => '#',
                'icon' => 'feather icon-menu',
                'children' =>
                array(
                    array(
                        'title' => 'Second Level',
                        'url' => '#',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Second Level',
                        'url' => '#',
                        'icon' => 'feather icon-circle',
                        'children' =>
                        array(
                            array(
                                'title' => 'Third Level',
                                'url' => '#',
                                'icon' => 'feather icon-circle',
                            ),
                            array(
                                'title' => 'Third Level',
                                'url' => '#',
                                'icon' => 'feather icon-circle',
                            ),
                        ),
                    ),
                    array(
                        'title' => 'Third Level',
                        'url' => '#',
                        'icon' => 'feather icon-circle',
                    ),
                    array(
                        'title' => 'Third Level',
                        'url' => '#',
                        'icon' => 'feather icon-circle',
                    ),
                ),
            ),
            array(
                'title' => 'Disabled Menu',
                'url' => '#',
                'icon' => 'feather icon-eye-off',
            ),
            array(
                'title' => 'Support',
                'class' => 'navigation-header',
            ),
            array(
                'title' => 'Documentation',
                'url' => 'https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation',
                'icon' => 'feather icon-folder',
            ),
            array(
                'title' => 'Raise Support',
                'url' => 'https://pixinvent.ticksy.com/',
                'icon' => 'feather icon-life-buoy',
            ),
        ];
    }
}
