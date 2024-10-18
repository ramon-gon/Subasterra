<?php

/**
 * Wrapper per a la funció session_start(). Fem servir això per assegurar-nos
 * que la sessió no s'ha iniciat ja abans de cridar aquesta funció i així evitar
 * warnings.
 */
function lazy_session_start() {
  if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_start();
  }
}