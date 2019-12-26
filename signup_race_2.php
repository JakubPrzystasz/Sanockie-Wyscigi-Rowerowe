<?php

@require_once("core/core.php");

if (is_logged()) {
    if (isset($_GET['race_id']) AND !isset($_GET['quick_signup_user_id'])) {
        $rows = $db->num_rows(sprintf("SELECT * FROM `races` WHERE `races`.`url_id` = '%s';", $_GET['race_id']));
        if ($rows > 0) {
            $array = $db->fetch(sprintf("SELECT * FROM `races` WHERE `races`.`url_id` = '%s';", $_GET['race_id']));
            $user = $db->fetch(sprintf("SELECT `login`,`complete` FROM `users` WHERE `users`.`user_id` = '%s';", $_COOKIE['USER_ID']));
            $rows = $db->num_rows(sprintf("SELECT * FROM `race_%s` WHERE `race_%s`.`user_login` = '%s';", $array['url_id'], $array['url_id'], $user['login']));
            if ($rows < 1) {
                if ($user['complete'] != 0) {
                    $today = DateTime::createFromFormat('U', time());
                    $today = $today->format('Y-m-d');
                    if ($array['date'] >= $today) {
                        $temp = $db->fetch_all(sprintf("SELECT * FROM `race_%s`;", $array['url_id']));
                        $signed = 0;
                        foreach ($temp as $key => $val) {
                            $us = $db->fetch(sprintf("SELECT `name` FROM `users` WHERE `login` = '%s'", $temp[$key]['user_login']));
                            if ($us['name'] != "TEST") {
                                $signed++;
                            }
                        }
                        if ($array['signup_limit'] == NULL) {
                            $array['signup_limit'] = 1000000;
                        }
                        if ($array['signup_limit'] > $signed) {

                            //sa wolne numery
                            $ids = $db->fetch_all(sprintf("SELECT * FROM `identificators` WHERE `id` <= %s", $array['signup_limit']));
                            foreach ($ids as $key => $val) {
                                $row = $db->num_rows(sprintf("SELECT `id`,`user_id` FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';", $array['url_id'], $array['url_id'], $ids[$key]['uid']));
                                if ($row < 1) {
                                    $available_id = $ids[$key]['uid'];
                                    $available_id_id = $ids[$key]['id'];
                                    break;
                                }
                            }

                            $db->query(sprintf("INSERT INTO `race_%s` (`id`, `user_login`, `user_id`, `score`, `start`, `finish`, `insurance`) VALUES (NULL, '%s', '%s', NULL, NULL, NULL,%s);", $array['url_id'], $user['login'], $available_id, $_GET['insurance']));

                            set_notification(SIGNED_DONE . " " . YOUR_NUMBER . ": " . $available_id, "success");
                            header("Location: index");
                        } else {
                            set_notification(ERRNO_32, "danger");
                            header("Location: index");
                        }
                    } else {
                        set_notification(ERRNO_36, "warning");
                        header("Location: index");
                    }
                } else {
                    set_notification(ERRNO_33, "warning");
                    header("Location: index");
                }
            } else {
                $db->query(sprintf("UPDATE `race_%s` SET `insurance` = '%s' WHERE `user_login` = '%s';", $_GET['race_id'], $_GET['insurance'], $user['login']));
                set_notification(CHANGES_SET, "success");
                header("Location: index");
            }
        } else {
            set_notification(ERRNO_30, "danger");
            header("Location: index");
        }
    }
    if (isset($_GET['quick_signup_user_id']) AND !isset($_GET['race_id']) AND is_admin()) {
        $array = $db->fetch("SELECT `url_id`,`signup_limit` FROM `races` WHERE `date` = CURDATE()");
        if ($array != NULL) {
            $rows = $db->num_rows(sprintf("SELECT `id` FROM `race_%s`", $array['url_id']));
            $temp = $db->fetch_all(sprintf("SELECT * FROM `race_%s`;", $array['url_id']));
            $signed = 0;
            foreach ($temp as $key => $val) {
                $us = $db->fetch(sprintf("SELECT `name` FROM `users` WHERE `login` = '%s'", $temp[$key]['user_login']));
                if ($us['name'] != "TEST") {
                    $signed++;
                }
            }
            if ($array['signup_limit'] == NULL) {
                $array['signup_limit'] = 1000000;
            }
            if ($array['signup_limit'] > $signed) {
                $user = $db->fetch(sprintf("SELECT `login`,`complete` FROM `users` WHERE `id` = '%s'", $_GET['quick_signup_user_id']));
                $user_signed = $db->fetch(sprintf("SELECT `id` FROM `race_%s` WHERE `user_login` = '%s'", $array['url_id'], $user['login']));
                if ($user_signed['id'] == NULL) {
                    if ($user['complete'] == 1) {
                        $classification = $db->fetch("SELECT * FROM `classifications` WHERE `url_id` = 66935");
                        $races = explode(',', $classification['races']);
                        $all_races = $db->fetch_all("SELECT `url_id` FROM `races` ORDER BY `date` ASC");
                        $race = array();
                        foreach ($all_races as $key => $val) {
                            if (in_array($val['url_id'], $races) == true) {
                                $data = $db->fetch(sprintf("SELECT `short_name`,`url_id` FROM `races` WHERE `url_id` = '%s';", $val['url_id']));
                                $race[] = [$data['url_id'] => $data['short_name']];
                            }
                        }
                        $race_flag = false;
                        $scores = array();
                        foreach ($race as $key => $val) {
                            $score = $db->fetch_all(sprintf("SELECT `score`,`user_login` FROM race_%s WHERE `score` IS NOT NULL AND `finish` IS NOT NULL ORDER BY `score` ASC", key($race[$key])));
                            if (!is_null($score)) {
                                $index = 0;
                                foreach ($score as $score_key => $score_val) {
                                    //compute score for each competitor in category
                                    if ($index == 0) {
                                        $points = 50;
                                    } elseif ($index == 1) {
                                        $points = 46;
                                    } elseif ($index > 1 && $index < 6) {
                                        $z = $index - 1;
                                        $points = 46 - (3 * $z);
                                    } elseif ($index > 5 && $index < 15) {
                                        $z = $index - 5;
                                        $points = 34 - (2 * $z);
                                    } elseif ($index == 15) {
                                        $z = $index - 15;
                                        $points = 15;
                                    } elseif ($index > 15 && $index < 31) {
                                        $z = $index - 15;
                                        $points = 15 - (1 * $z);
                                    } else {
                                        $points = 0;
                                    }
                                    if (isset($scores[$score_val['user_login']])) {
                                        $scores[$score_val['user_login']][$val[key($race[$key])]] = $points;
                                    } else {
                                        $scores[$score_val['user_login']] = array($val[key($race[$key])] => $points);
                                    }
                                    $index++;
                                }
                            }
                        }
                        $temp = array();
                        foreach ($race as $key => $val) {
                            foreach ($val as $val) {
                                $temp[] = $val;
                            }
                        }
                        $race = $temp;
                        unset($temp);
                        foreach ($scores as $key => $val) {
                            $temp = array();
                            foreach ($val as $vkey => $vval) {
                                if ($vkey != "score") {
                                    array_push($temp, $vval);
                                }
                            }
                            rsort($temp);
                            $scores[$key]['score'] = 0;
                            for ($i = 0; $i < 3; $i++) {
                                if (isset($temp[$i]) && $temp[$i] != NULL) {
                                    $scores[$key]['score'] += $temp[$i];
                                }
                            }
                            unset($temp);
                        }
                        foreach ($race as $key => $val) {
                            foreach ($scores as $k => $v) {
                                if (!isset($v[$val]) OR $v[$val] == NULL) {
                                    $scores[$k][$val] = 0;
                                }
                            }
                        }
                        //sort by score
                        sort_array($scores, "score");
                        $temp = array();
                        $temp = $scores;
                        $scores = array();
                        foreach ($temp as $key => $val) {
                            $scores[$key] = $val['score'];
                        }
                        unset($temp, $score);


                        if (array_key_exists($user['login'], $scores)) {
                            $i = 0;
                            foreach ($scores as $key => $val) {
                                if ($key == $user['login']) {
                                    break;
                                } else {
                                    $i++;
                                }
                            }
                            if ($i <= 30) {
                                //zawodnik jest klasyfikowany
                                $user_idd = 60 - $i;
                                $num = $db->fetch(sprintf("SELECT * FROM `identificators` WHERE `id` = '%s'", $user_idd));
                                $rows = $db->num_rows(sprintf("SELECT * FROM `race_%s` WHERE `user_id` = '%s'", $array['url_id'], $num['uid']));
                                //mozna zapisac wolny numer
                                if ($rows == NULL) {
                                    $available_id_id = $num['id'];
                                    $available_id = $num['uid'];
                                } else {
                                    //trzeba ponizej 30
                                    $ids = $db->fetch_all(sprintf("SELECT * FROM `identificators` WHERE `id` <= %s", $array['signup_limit']));
                                    foreach ($ids as $key => $val) {
                                        $row = $db->num_rows(sprintf("SELECT `id`,`user_id` FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';", $array['url_id'], $array['url_id'], $ids[$key]['uid']));
                                        if ($row < 1) {
                                            $available_id = $ids[$key]['uid'];
                                            $available_id_id = $ids[$key]['id'];
                                            break;
                                        }
                                    }
                                }
                            }
                        } else {
                            //sa wolne numery
                            $ids = $db->fetch_all(sprintf("SELECT * FROM `identificators` WHERE `id` <= %s", $array['signup_limit']));
                            foreach ($ids as $key => $val) {
                                $row = $db->num_rows(sprintf("SELECT `id`,`user_id` FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';", $array['url_id'], $array['url_id'], $ids[$key]['uid']));
                                if ($row < 1) {
                                    $available_id = $ids[$key]['uid'];
                                    $available_id_id = $ids[$key]['id'];
                                    break;
                                }
                            }
                        }

                        $db->query(sprintf("INSERT INTO `race_%s` (`id`, `user_login`, `user_id`, `score`, `start`, `finish`, `insurance`) VALUES (NULL, '%s', '%s', NULL, NULL, NULL,NULL);", $array['url_id'], $user['login'], $available_id));
                        $message = QUICK_SIGNUP_DONE . "<br>" . REGISTER_NUMBER . ": " . $available_id_id;
                        echo json_encode(array('content' => $message, 'type' => 'alert alert-success'));
                    } else {
                        echo json_encode(array('content' => "<a href='index.php?site=edit_user&user_id=" . $_GET['quick_signup_user_id'] . "'>" . INCOMPLETE_ALERT . "</a>", 'type' => 'alert alert-danger'));
                    }
                } else {
                    echo json_encode(array('content' => ERRNO_47, 'type' => 'alert alert-danger'));
                }
            } else {
                echo json_encode(array('content' => ERRNO_32, 'type' => 'alert alert-danger'));
            }
        } else {
            echo json_encode(array('content' => ERRNO_30, 'type' => 'alert alert-danger'));
        }
    } else {
        header("Location:index");
    }
} else {
    set_notification(ERRNO_18, "warning");
    header("Location: login");
}
?>