<?php
return (new class {
    public function header()
    {
        return [
            "slug"          => "es",
            "name"          => "es_DO",
            "description"   => "Español República Dominicana",
        ];
    }
    
    public function body()
    {
        return [
            "auth.certify"      => "Cargar certificado",
            "auth.bad"          => "Credenciales incorrectas",
            "auth.logout"       => "Sesión cerrada",
            "auth.reject"       => "Autenticación rechazada",
            "auth.required"     => "Identificase por favor",

            "auth.rol.deny"     => "Acción denegada, no posee los permisos requeridos",
            "auth.delete.deny"  => "Rechazada por falta de permisos",
            "access.fishy"      => "Acceso sospechoso",

            "account.0"         => "Cuenta deshabilitada",
            "account.1"         => "Cuenta activa",
            "account.2"         => "Cuenta supendida",
            "account.3"         => "Cuenta bloqueada",
            "account.4"         => "Cuenta en legales",
            "account.5"         => "Cuenta eliminada",

            "api.request.session"    => "Solicitud de sesión a la api",

            "account.type"      => "Tipo de cuenta",

            "business.certify"  => "Certificado de la empresa",

            "business.delegate"         => "Estoy deacuerdo",
            "business.delete.title"     => "Eliminar cuenta coporativa",
            "business.delete.info"      => "Por motivo de seguridad, solo se autoriza destruir la entida, si y solo si, se cumple con los siguientes criterios",
            
            "business.delete.driving.0" => "Debe terner los permisos pertinentes",
            "business.delete.driving.1" => "La entidad debe estar bacía",
            "business.delete.driving.2" => "Debe proporcionar el nombre registrado de la entidad",
            
            "business.delete.delegate"  => "Agotado lo anterior, asume toda la responsabilidad y autoriza proceder",

            "business.email"        => "Correo de la empresa",
            "business.name"         => "Nombre de la empresa",
            "business.register"     => "Registro de entidades corporativas",
            "busuness.rnc"          => "Numero de contribuyente", 

            "business.update.name"  => "Actualizar nombre corporativo",

            "confirm.password"  => "Confirmar contraseña",
            "command.unknown"   => "Comando o orden desconocida",
            "corporate.group"   => "Grupo corporativo",

            "delete.successfully"   => "Datos elimininados correctamente",
            "delete.errors"         => "Error al tratar de eliminar los datos",

            "entity.access"     => "Acceso empresarial",
            "entity.name"       => "Nombre de la entidad",

            "form.login"        => "Formulario de acceso",
            "form.entities"     => "Registro de entidades",

            "identify.yourself"     => "Identificate",
            "install.description"   => "Instalación del aplicativo de soporte para DGII",
            "install.installed"     => "Aplicativo instalado",
            "insert.successfully"   => "Registro realizado correctamente",

            "new.password"          => "Nueva contraseña",

            "update.account"        => "Actualizar cuenta",
            "update.credentials"    => "Actualizar credenciales",
            "update.from.email"     => "Correo electrónico de la cuenta que desea actualizar",
            "update.password"       => "actualizar contraseña",
            "update.successfully"   => "Actualización realizada exitosamente",
            "update.error"          => "Error al tratar de actualizar los datos",

            "rol.empty"             => "No posee los permisos requeridos para esta operación",

            "validation.required"           => "El campo :attribute es requerido",
            "validation.bad.certify"        => "Certificado no válido o llave incorrecta",
            "validate.bad.name"             => "Nombre incorrecto",
            "validate.unique"               => "El :attribute existe en nuestros registros",
            "validation.has.entity"         => ":attribute no disponible",
            "validation.is_rnc"             => "RNC incorrecto",
            "validation.slug.entity"        => "Cuenta no disponible",
            "validation.entity.resources"   => "Error al tratar de crear los recursos de la entidad",
            "validator.name.business"       => "El :attribute existe en nuestros registros",
            'validation.is_encf'            => "Tipo de comprobante no valido",
            "words.actions"         => "Acciones",
            "words.accounts-users"        => "Cuentas de usuarios",
            "words.approved"        => "Aprobado",
            'words.account'         => "Cuenta",
            "words.auth"            => "Autenticar",
            "words.authentication"  => "Autenticaión",
            "words.certify"         => "Certificado",
            "words.close"           => "Cerrar",
            "words.credentials"     => "Credenciles",
            "words.deny"            => "Denegado",
            "words.delete"          => "Eliminar",
            "words.entities"        => "Entidades",
            "words.email"           => "Correo Electrónico",
            "words.identify"        => "Identificarse",
            "words.filters"         => "Filtrar",
            "words.groups"          => "Grupos",
            "words.login"           => "Acceder",
            "words.logout"          => "Salir",
            "words.users"           => "Usuarios",
            "words.update"          => "Actualizar",
            "words.name"            => "Nombre",
            "words.rnc"             => "RNC",

            "words.new"             => "Nuevo",
            "words.password"        => "Contraseña",
            "words.rejected"        => "Rechazado",
            'words.serial'          => "Serial",
            "words.state"           => "Estado",
            "words.search"          => "Buscar",
            "words.slug"            => "Nombre amigable",

            "state.0" => "Inactivo|inactivar",
            "state.1" => "Activo|Activar",
            "state.2" => "Deshabilitado|Deshabilitar",
            "state.3" => "Bloqueado|Bloquear",
            "state.4" => "Intervenido|Intervenir",
        ];
    }
});