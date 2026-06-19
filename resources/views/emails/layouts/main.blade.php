<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body style="margin:0;padding:0;background:#E9E9E9;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff">
        <tr>
            <td align="center">
                <table width="700" cellpadding="10" cellspacing="0" border="0" style="background:#E9E9E9;">
                    {{-- Header --}}
                    <tr>
                        <td style="text-align: center">
                            <img src="{{ asset('images/logo_black_flag.png') }}" alt="Black Flag" height="80" style="width:80px; height: 80px; margin-right: 20px">
                            <img src="{{ asset('images/logo_rapid_repel.png') }}" alt="Rapid Repel" height="80" style="width:80px; height: 80px; margin-left: 20px">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('images/banner_email.png') }}" alt="Rapid Repel" width="100%" style="display:block;width:100%;">
                        </td>
                    </tr>

                    {{-- Card blanca --}}
                    <tr>
                        <td align="center">
                            <table width="540" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; border-radius:12px; margin-top:-60px; position:relative;">
                                <tr>
                                    <td style="padding:40px;">
                                        @yield('content')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Botón --}}
                    @hasSection('button')
                        <tr>
                            <td align="center" style="padding:50px 0;">
                                @yield('button')
                            </td>
                        </tr>
                    @endif

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#00543D; border-top:5px solid #FDB913; padding:30px; color:#ffffff; font-size:14px; line-height:22px; text-align: center">
                            Oferta válida del 15 de Junio de 2026 al 15 de Julio de 2026 <br>
                            <a href="https://activatupasion.com/T%C3%A9rminos%20y%20Condiciones%20de%20la%20Promocion%20-%20Activa%20tu%20pasi%C3%B3n.pdf" class="text-yellow underline">
                                Consulta términos y condiciones
                            </a> en activatupasion.com <br>

                            "Lea la etiqueta antes de usar el producto", "Ningún envase o empaque que haya contenido plaguicidas puede
                            usarse para contener alimentos o agua, para consumo humano y animal" y "Manténgase fuera del alcance de los
                            niños, alejado de animales y alimento". "Este(os) producto(s) no puede(n) aplicarse sobre las personas,
                            plantas ni animales, tampoco sobre los alimentos" y "Después de la aplicación debe esperar el tiempo recomendado
                            en la etiqueta antes de ingresar al lugar".

                            <br>

                            © 2026 Rapid Repel & Black Flag. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
