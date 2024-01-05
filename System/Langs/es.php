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

            "business.certify"  => "Certificado de la empresa",
            "business.delete.title"   => "Eliminar cuenta coporativa",
            "business.delete.info"  => "Por motivo de seguridad, solo se autoriza proceder al cumplir con los siguientes criterios.",
            "business.delete.driving.0" => "La entidad debe estar bacía",
            "business.delete.driving.1" => "Toda responsabilidad recae sobre la persona autorizada que solicita",
            "business.email"    => "Correo de la empresa",
            "business.name"     => "Nombre de la empresa",
            "business.register" => "Registro de entidades corporativas", 

            "business.update.name" => "Actualizar nombre corporativo",

            "confirm.password"  => "Confirmar contraseña",
            "command.unknown"   => "Comando o orden desconocida",
            "entity.access"     => "Acceso empresarial",

            "form.login"        => "Formulario de acceso",
            "form.entities"     => "Registro de entidades",

            "install.description"   => "Instalación del aplicativo de soporte para DGII",
            "install.installed"     => "Aplicativo instalado",
            "new.password"          => "Nueva contraseña",

            "update.account"        => "Actualizar cuenta",
            "update.from.email"     => "Correo electrónico de la cuenta que desea actualizar",

            "validation.required"       => "El campo :attribute es requrido",
            "validation.bad.certify"    => "Certificado no válido o llave incorrecta",
            "validation.has.entity"     => "Entidad no disponible",
            "validation.slug.entity"     => "Cuenta no disponible",
            "validator.name.business"   =>"El :attribute existe en nuestros registros",

            "words.actions"         => "Acciones",
            'words.account'         => "Cuenta",
            "words.auth"            => "Autenticar",
            "words.authentication"  => "Autenticaión",
            "words.certify"         => "Certificado",
            "words.close"           => "Cerrar",
            "words.credentials"     => "Credenciles",
            "words.delete"          => "Eliminar",
            "words.entities"        => "Entidades",
            "words.email"           => "Correo Electrónico",
            "words.login"           => "Acceder",
            "words.logout"          => "Salir",
            "words.users"           => "Usuarios",
            "words.update"          => "Actualizar",
            "words.name"            => "Nombre",
            "words.password"        => "Contraseña",
            "words.state"           => "Estado",
            "words.search"          => "Buscar",

            "state.0" => "Inactivo|inactivar",
            "state.1" => "Activo|Activar",
            "state.2" => "Deshabilitado|Deshabilitar",
            "state.3" => "Bloqueado|Bloquear",
            "state.4" => "Intervenido|Intervenir",
        ];
    }
});