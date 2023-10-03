<?php

switch (K_DATABASE_TYPE) {
    case 'MYSQL': {
        require_once('../../shared/code/tce_db_dal_mysqli.php');
        break;
    }
    case 'POSTGRESQL': {
        require_once('../../shared/code/tce_db_dal_postgresql.php');
        break;
    }
    case 'ORACLE': {
        require_once('../../shared/code/tce_db_dal_oracle.php');
        break;
    }
    case 'MYSQLDEPRECATED': {
        require_once('../../shared/code/tce_db_dal_mysql.php');
        break;
    }
    default: {
        F_print_error('ERROR', 'K_DATABASE_TYPE is not set!');
    }
}

//============================================================+
// END OF FILE
//============================================================+
