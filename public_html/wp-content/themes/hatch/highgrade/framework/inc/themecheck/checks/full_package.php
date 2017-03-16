<?php

    class Redux_Full_Package implements themecheck {
        protected $error = array();

        function check( $php_files, $css_files, $other_files ) {

            $ret = true;

            $check = Redux_ThemeCheck::get_instance();
            $redux = $check::get_redux_details( $php_files );

            if ( $redux ) {

                $blacklist = array(
                    '.tx'                    => __( 'Redux localization utilities', 'hatch' ),
                    'bin'                    => __( 'Redux Resting Diles', 'hatch' ),
                    'codestyles'             => __( 'Redux Code Styles', 'hatch' ),
                    'tests'                  => __( 'Redux Unit Testing', 'hatch' ),
                    'class.redux-plugin.php' => __( 'Redux Plugin File', 'hatch' ),
                    'bootstrap_tests.php'    => __( 'Redux Boostrap Tests', 'hatch' ),
                    '.travis.yml'            => __( 'CI Testing FIle', 'hatch' ),
                    'phpunit.xml'            => __( 'PHP Unit Testing', 'hatch' ),
                );

                $errors = array();

                foreach ( $blacklist as $file => $reason ) {
                    checkcount();
                    if ( file_exists( $redux['parent_dir'] . $file ) ) {
                        $errors[ $redux['parent_dir'] . $file ] = $reason;
                    }
                }

                if ( ! empty( $errors ) ) {
                    $error = '<span class="tc-lead tc-required">REQUIRED</span> ' . __( 'It appears that you have embedded the full Redux package inside your theme. You need only embed the <strong>ReduxCore</strong> folder. Embedding anything else will get your rejected from theme submission. Suspected Redux package file(s):', 'hatch' );
                    $error .= '<ol>';
                    foreach ( $errors as $key => $e ) {
                        $error .= '<li><strong>' . $e . '</strong>: ' . $key . '</li>';
                    }
                    $error .= '</ol>';
                    $this->error[] = '<div class="redux-error">' . $error . '</div>';
                    $ret           = false;
                }
            }

            return $ret;
        }

        function getError() {
            return $this->error;
        }
    }

    $themechecks[] = new Redux_Full_Package();