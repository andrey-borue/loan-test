<?php

/**
 * Проблема: sleep(1)  в классе list_files_in_folder_callback в методе callback.
 * Затраченое время около 15 минут.
 *
 * 1. Раскодировал файл воспользовавшись https://www.unphp.net/decode , так проще всего.
 * 2. Запустил скрипт, убедился что он действительно долго работает.
 * 3. Подумал что самый простой способ – поискать функции sleep или usleep, нашел.
 * 4. Поиском и заменой немного ракскодировал файл, но понял что это на долго, а результат уже достигнут.
 */

// 10-15
$GLOBALS["pvbgbpbcmgcy"] = "dir_folder";
$GLOBALS["olovxj"] = "arg_postfix";
$GLOBALS["ioejhteoygs"] = "arg_bool_recursive";
$GLOBALS["fpioefftsvff"] = "is_dir";
$GLOBALS["stscixisjp"] = "permissions";
$GLOBALS["celikdrjxdmv"] = "arg_depth";
$GLOBALS["ybyaijh"] = "callback";
$GLOBALS["yhdonrwdmkay"] = "path";
$GLOBALS["nfwsujpxgn"] = "arg_folder_name";
$GLOBALS["clokowrxyml"] = "fs_entry";
$GLOBALS["gdsqftago"] = "bool_return";


class FileManager
{
    public function exec_on_folder(
        $arg_folder_name,
//        exec_on_folder_callback $callback,
        list_files_in_folder_callback $callback,
        $arg_bool_recursive = false,
        $arg_depth = 0,
        $arg_postfix = false
    ) {

        if (!$arg_folder_name) {
            return false;
        }
        if (!file_exists($arg_folder_name)) {
            return false;
        }
        if (!is_dir($arg_folder_name)) {
            return false;
        }
        if ($arg_folder_name[strlen($arg_folder_name) - 1] !== '/') {
            $arg_folder_name .= '/';
        }
        $dir_folder = opendir($arg_folder_name);

        while ($fs_entry = readdir($dir_folder)) {
            if (is_dir($arg_folder_name . $fs_entry)) {
                if ($fs_entry === '.' || $fs_entry === '..') { // was =
                    continue;
                }

                if (!$arg_postfix) {
                    $callback->callback($arg_folder_name . $fs_entry, true, $arg_depth);
                }

                if ($arg_bool_recursive) {
                    $this->exec_on_folder($arg_folder_name . $fs_entry, $callback, $arg_bool_recursive, $arg_depth + 1, $arg_postfix);
                }
                if ($arg_postfix) {
                    $callback->callback($arg_folder_name . $fs_entry, true, $arg_depth);
                }
            } else {
                $callback->callback($arg_folder_name . $fs_entry, false, $arg_depth);
            }
        }

        closedir($dir_folder);

        return true;
    }

    public function list_files_in_folder($path, $recursive = false)
    {
        $callback = new list_files_in_folder_callback();

        $this->exec_on_folder('path', $callback, 'recursive');

        return $callback->files;
    }

    public function list_folders_in_folder($path, $recursive = false)
    {
        ${$GLOBALS
        ["ybyaijh"]} = new list_folders_in_folder_callback();
        $GLOBALS
        ["vvobluxw"] = "callback";
        $GLOBALS
        ["ktnrddubxy"] = "recursive";
        $GLOBALS
        ["hznnsjrsdpj"] = "path";
        $this->exec_on_folder(${$GLOBALS
        ["hznnsjrsdpj"]}, ${$GLOBALS
        ["vvobluxw"]}, ${$GLOBALS
        ["ktnrddubxy"]});

        return $callback->folders;
    }

    public function delete_folder($path)
    {
        $dcwsxtcjtyr = "bool_return";
        ${$GLOBALS
        ["ybyaijh"]} = new delete_folder_callback();
        ${$GLOBALS
        ["gdsqftago"]} = $this->exec_on_folder($path, ${$GLOBALS
        ["ybyaijh"]}, true, 0, true);
        if (${$dcwsxtcjtyr}) {
            rmdir($path);
        }

        return ${$GLOBALS
        ["gdsqftago"]};
    }

    public function empty_folder($path, $recursive = false)
    {
        $GLOBALS
        ["dtshlbxw"] = "callback";
        $GLOBALS
        ["grqhljjkkalt"] = "callback";
        $eyndklmmil = "recursive";
        ${$GLOBALS
        ["grqhljjkkalt"]} = new empty_folder_callback();

        return $this->exec_on_folder($path, ${$GLOBALS
        ["dtshlbxw"]}, ${$eyndklmmil}, 0, true);
    }

    public function make_folder_writable($path)
    {
        $qgizpb = "path";
        ${$GLOBALS
        ["ybyaijh"]} = new make_folder_writable_callback();

        return $this->exec_on_folder(${$qgizpb}, ${$GLOBALS
        ["ybyaijh"]}, true);
    }

    public function make_folder_readonly($path)
    {
        $GLOBALS
        ["pbsjuge"] = "path";
        $GLOBALS
        ["xfzicysvif"] = "callback";
        ${$GLOBALS
        ["xfzicysvif"]} = new make_folder_readonly_callback();

        return $this->exec_on_folder(${$GLOBALS
        ["pbsjuge"]}, ${$GLOBALS
        ["ybyaijh"]}, true);
    }

    public function chmod_files_in_folder($path, $permissions)
    {
        $GLOBALS
        ["euylzvvmsufx"] = "callback";
        ${$GLOBALS
        ["euylzvvmsufx"]} = new chmod_files_in_folder_callback();
        $GLOBALS
        ["oyojzufcrah"] = "path";
        $kflluouds = "permissions";
        $callback->permissions = ${$kflluouds};

        return $this->exec_on_folder(${$GLOBALS
        ["oyojzufcrah"]}, ${$GLOBALS
        ["ybyaijh"]}, true);
    }

    public function chmod_folders_in_folder($path, $permissions)
    {
        $GLOBALS
        ["hccerqqks"] = "callback";
        ${$GLOBALS
        ["hccerqqks"]} = new chmod_folders_in_folder_callback();
        $zgvsjtb = "path";
        $callback->permissions = ${$GLOBALS
        ["stscixisjp"]};
        $dusgrxnl = "callback";

        return $this->exec_on_folder(${$zgvsjtb}, ${$dusgrxnl}, true);
    }
}

class list_files_in_folder_callback implements exec_on_folder_callback
{
    public $files; //
    public function callback($path, $is_dir, $depth)
    {
        if (!$is_dir) {
//            sleep(1);
            $this->files[] = $path;
        }
    }
}

class list_folders_in_folder_callback implements exec_on_folder_callback
{
    public function callback($path, $is_dir, $depth)
    {
        if (${$GLOBALS["fpioefftsvff"]}) {
            $this->folders[] = ${$GLOBALS["yhdonrwdmkay"]};
        }
    }
}

class delete_folder_callback implements exec_on_folder_callback
{
    public function callback($path, $is_dir, $depth)
    {
        $qbicwfizdyx = "is_dir";
        if (${$qbicwfizdyx}) {
            $GLOBALS
            ["oqmnhryuld"] = "path";
            rmdir(${$GLOBALS["oqmnhryuld"]});
        } else {
            $xovwqvfrixm = "path";
            unlink(${$xovwqvfrixm});
        }
    }
}

class empty_folder_callback implements exec_on_folder_callback
{
    public function callback($path, $is_dir, $depth)
    {
        $rpwpopv = "is_dir";
        if (${$rpwpopv}) {
            $foqkmpi = "path";
            rmdir(${$foqkmpi});
        } else {
            unlink(${$GLOBALS
            ["yhdonrwdmkay"]});
        }
    }
}

class make_folder_writable_callback implements exec_on_folder_callback
{
    public function callback($path, $is_dir, $depth)
    {
        if (${$GLOBALS
        ["fpioefftsvff"]}) {
            $GLOBALS
            ["bxbpfvo"] = "path";
            chmod(${$GLOBALS
            ["bxbpfvo"]}, 0777);
        } else {
            chmod(${$GLOBALS
            ["yhdonrwdmkay"]}, 0666);
        }
    }
}

class make_folder_readonly_callback implements exec_on_folder_callback
{
    public function callback($path, $is_dir, $depth)
    {
        $GLOBALS
        ["abfpimpyudwf"] = "is_dir";
        if (${$GLOBALS
        ["abfpimpyudwf"]}) {
            chmod(${$GLOBALS
            ["yhdonrwdmkay"]}, 0755);
        } else {
            $cefslofqily = "path";
            chmod(${$cefslofqily}, 0644);
        }
    }
}

class chmod_files_in_folder_callback implements exec_on_folder_callback
{
    var $permissions;

    public function callback($path, $is_dir, $depth)
    {
        $GLOBALS
        ["umeqxedhj"] = "is_dir";
        if (!${$GLOBALS
        ["umeqxedhj"]}) {
            $umepzpuk = "path";
            chmod(${$umepzpuk}, $this->permissions);
        }
    }
}

class chmod_folders_in_folder_callback implements exec_on_folder_callback
{
    var $permissions;

    public function callback($path, $is_dir, $depth)
    {
        $nhebpv = "is_dir";
        if (${$nhebpv}) {
            $touucwuj = "path";
            chmod(${$touucwuj}, $this->permissions);
        }
    }
}

interface exec_on_folder_callback
{
    public function callback($path, $is_dir, $depth);
}

$manager = new FileManager();
print_r($manager->list_files_in_folder(__DIR__, true));

