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
            "business.update.certify"  => "Actualizar certificado corporativo",

            "confirm.password"  => "Confirmar contraseña",
            "command.unknown"   => "Comando o orden desconocida",
            "corporate.group"   => "Grupo corporativo",

            "delete.successfully"   => "Datos elimininados correctamente",
            "delete.errors"         => "Error al tratar de eliminar los datos",

            "download.xml"      => "Descargar XML",

            "entity.access"     => "Acceso empresarial",
            "entity.name"       => "Nombre de la entidad",

            "entity.env.selected" => "Ambiente de trabajo seleccionado",
            "entity.testecf"    => "Pre-Certificación",
            "entity.certecf"    => "Certificación",
            "entity.ecf"        => "Producción",
            "entity.owner"      => "Mis Instituciones",

            "ecf.lists"         => "Listar comprobantes",
            "ecf.filters.by"    => "Filtro por",

            "acecf.issuance"    => "Emisión de la aprobación comercial",

            "filter.by.eNCF"    => "Filtrar por eNCF",
            "filter.by.date"    => "Filtrar por fecha",
            "filter.by.RNC"     => "Filtrar por RNC",

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

            "user.fullname"         => "Nombre completo  para el usuario",

            "lists.show"            => "Mostrar listas",
            "lists.encf.all"        => "Listar todos los comprobantes",
            "lists.encf.processed"  => "Listar comprobantes procesados",
            "lists.encf.complete"   => "Listar comprobantes sin procesados",

            "rol.empty"             => "No posee los permisos requeridos para esta operación",
            
            "register.users"        => "Registros de usuarios",

            "validation.required"           => "El campo :attribute es requerido",
            "validation.bad.certify"        => "Certificado no válido o llave incorrecta",
            "validate.bad.name"             => "Nombre incorrecto",
            "validate.unique"               => "El :attribute existe en nuestros registros",
            "validation.has.entity"         => ":attribute no disponible",
            "validation.is_rnc"             => "RNC no es valido",
            "validation.slug.entity"        => "Cuenta no disponible",
            "validation.entity.resources"   => "Error al tratar de crear los recursos de la entidad",
            "validator.name.business"       => "El :attribute existe en nuestros registros",
            'validation.is_encf'            => "Tipo de comprobante no valido",
            'validate.ecf.unique'           => "Este :attribute no está disponible para procesar",
            'validate.ecf.expira'           => "El tiempo permitido para enviar la aprobacion comercion expiro",

            "words.actions"         => "Acciones",
            "words.accounts-users"  => "Cuentas de usuarios",
            "words.arecf"           => "Acuse de recibo",
            "words.approved"        => "Aprobado",
            'words.account'         => "Cuenta",
            "words.auth"            => "Autenticar",
            "words.authentication"  => "Autenticaión",
            "words.acecf"           => "Aprobación Comercial",
            "words.back"            => "Retroceder",
            "words.certify"         => "Certificado",
            "words.close"           => "Cerrar",
            "words.credentials"     => "Credenciles",
            "words.date"            => "Fecha",
            "words.deny"            => "Denegado",
            "words.delete"          => "Eliminar",
            "words.download"        => "Descargar",
            "words.eNCF"            => "eNCF",
            "words.entities"        => "Entidades",
            "words.entity"          => "Entidad",
            "words.email"           => "Correo Electrónico",
            "words.home"            => "Inicio",
            "words.identify"        => "Identificarse",
            "words.filters"         => "Filtrar",
            "words.FechaHoraAcuseRecibo" => "Fecha",
            "words.groups"          => "Grupos",
            "words.login"           => "Acceder",
            "words.logout"          => "Salir",
            "words.users"           => "Usuarios",
            "words.update"          => "Actualizar",
            "words.mixed"           => "Mesclados",
            'words.pending'         => "Pendientes",
            'words.processing'      => "Procesando",
            'words.processed'       => "Procesados",
            "words.registers"       => "Registros",
            "words.name"            => "Nombre",
            "words.rnc"             => "RNC",
            "words.RNCComprador"    => "RNC",
            "words.register"        => "Registro",

            "words.message"         => "Mensaje",
            "words.new"             => "Nuevo",
            "words.password"        => "Contraseña",
            "words.rejected"        => "Rechazado",
            "words.send"            => "Enviar",
            'words.serial'          => "Serial",
            "words.state"           => "Estado",
            "words.search"          => "Buscar",
            "words.subject"         => "Asunto",
            "words.slug"            => "Nombre amigable",
            "words.to-lists"        => "Listar",

            "send.xml"              => "Enviar XML",

            "state.0" => "Inactivo|inactivar",
            "state.1" => "Activo|Activar",
            "state.2" => "Deshabilitado|Deshabilitar",
            "state.3" => "Bloqueado|Bloquear",
            "state.4" => "Intervenido|Intervenir",
        ];
    }
});