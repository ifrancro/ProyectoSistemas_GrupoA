<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academia\Capacitacion;
use App\Models\Academia\CapacitacionNivel;
use App\Models\Academia\QuizPregunta;
use App\Models\Academia\QuizRespuesta;

class AcademiaSeeder extends Seeder
{
    public function run(): void
    {
        // Capacitación para JURADOS
        $capacitacionJurado = Capacitacion::create([
            'titulo' => 'Curso de Capacitación para Jurados Electorales de Bolivia',
            'descripcion' => 'Curso completo para capacitar a los ciudadanos que ejercerán como jurados en las mesas de votación. Incluye fundamentos legales, procedimientos operativos y gestión de incidentes.',
            'rol_destino' => 'JURADO',
            'estado' => 'ACTIVO',
            'total_niveles' => 3,
            'puntaje_minimo' => 90,
        ]);

        // Niveles para Jurados
        $nivel1Jurado = CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'numero_nivel' => 1,
            'titulo' => 'Fundamentos del Rol del Jurado Electoral',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Comprender el marco legal y ético del rol del jurado.
Identificar las responsabilidades antes, durante y después de la jornada electoral.
Conocer la estructura y funcionamiento del proceso electoral boliviano.

CONTENIDOS

1. INTRODUCCIÓN AL PROCESO ELECTORAL BOLIVIANO

• Órgano Electoral Plurinacional (OEP) y sus funciones
• Tribunal Supremo Electoral (TSE) y Tribunales Electorales Departamentales (TED)
• Tipos de elecciones: generales, subnacionales, referendos y revocatorias

2. MARCO LEGAL

• Constitución Política del Estado (artículos sobre soberanía y voto)
• Ley del Régimen Electoral N° 026
• Infracciones electorales y sanciones

3. ROL DEL JURADO ELECTORAL

• Definición y designación (sorteo público)
• Inamovilidad el día de la elección
• Derechos (alimentación, viáticos, certificación de servicio)
• Deberes (imparcialidad, puntualidad, responsabilidad)

4. ÉTICA Y CONDUCTA

• Prohibición de propaganda política
• Neutralidad frente a partidos y candidatos
• Confidencialidad del voto y respeto al secreto electoral",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 20,
            'requiere_completar' => true,
        ]);

        $nivel2Jurado = CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'numero_nivel' => 2,
            'titulo' => 'Desarrollo de la Jornada Electoral',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Dominar el procedimiento completo de votación.
Aplicar correctamente las normas de apertura, sufragio y cierre de mesa.
Identificar y resolver incidencias comunes durante el proceso.
CONTENIDOS

1. PREPARATIVOS PREVIOS

• Recepción del material electoral (urnas, papeletas, actas, sobres)
• Verificación del recinto y señalización
• Conformación de la mesa (presidente, secretario y vocales)

2. APERTURA DE LA MESA

• Acta de apertura y verificación de materiales
• Instalación ante veedores y delegados partidarios
• Inicio puntual (08:00 am)

3. PROCESO DE VOTACIÓN

• Recepción del votante y verificación en el padrón
• Entrega de papeletas y sello en el dedo índice derecho
• Voto secreto: ingreso al biombo, marcado y depósito en la urna

4. CASOS ESPECIALES

• Votante no registrado en el padrón
• Documento deteriorado o ilegible
• Personas con discapacidad o de la tercera edad

5. CIERRE DE MESA

• Cierre a las 17:00 (salvo votantes en fila)
• Conteo de votos y llenado de actas
• Firma de jurados, delegados y veedores
• Entrega de materiales al notario electoral

MATERIAL AUDIOVISUAL

Para complementar este nivel, te recomendamos ver el siguiente video que muestra el proceso completo de votación en una mesa electoral:

Video: Procedimiento Electoral Completo
Duración: Material complementario
Tipo: Demostración práctica",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 25,
            'requiere_completar' => true,
            'archivo_url' => 'https://youtu.be/pumTlDOLv0U',
        ]);

        $nivel3Jurado = CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'numero_nivel' => 3,
            'titulo' => 'Ética, Transparencia y Gestión de Incidentes',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Reforzar la transparencia y confianza ciudadana en el proceso.
Manejar correctamente situaciones conflictivas o de riesgo.
Conocer la cadena de custodia de materiales electorales.

CONTENIDOS

1. TRANSPARENCIA Y CONTROL SOCIAL

• Participación de veedores e instituciones
• Coordinación con delegados partidarios
• Importancia de la documentación correcta y legible

2. SEGURIDAD Y ORDEN

• Normas ante disturbios o desorden
• Comunicación inmediata al notario electoral o Fuerza Pública
• Procedimiento en caso de pérdida o daño de material

3. INCIDENTES COMUNES

• Votos nulos y blancos: cómo identificarlos
• Reclamaciones de delegados: procedimiento
• Actas con errores: corrección y observaciones válidas

4. ÉTICA FINAL DEL JURADO

• Responsabilidad cívica y ejemplo ciudadano
• Certificación de cumplimiento de funciones
• Repercusiones legales del incumplimiento

MATERIAL AUDIOVISUAL

Para complementar este nivel, te recomendamos ver los siguientes videos que muestran casos prácticos de gestión de incidentes y ética electoral:

Video 1: Gestión de Incidentes Electorales
Video 2: Ética y Transparencia en el Proceso Electoral",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 30,
            'requiere_completar' => true,
            'archivo_url' => 'https://youtu.be/89wnauanqaQ',
        ]);

        // Preguntas del quiz para Jurados
        $pregunta1 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Quién designa a los jurados electorales?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta1->id_pregunta, 'opcion' => 'Los partidos políticos', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta1->id_pregunta, 'opcion' => 'El Tribunal Supremo Electoral', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta1->id_pregunta, 'opcion' => 'Los notarios electorales', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta1->id_pregunta, 'opcion' => 'El Gobierno central', 'es_correcta' => false, 'orden' => 4]);

        $pregunta2 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿A qué hora deben abrir las mesas de sufragio?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta2->id_pregunta, 'opcion' => '07:00', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta2->id_pregunta, 'opcion' => '08:00', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta2->id_pregunta, 'opcion' => '09:00', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta2->id_pregunta, 'opcion' => '10:00', 'es_correcta' => false, 'orden' => 4]);

        $pregunta3 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué documento se utiliza para registrar los resultados de la mesa?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta3->id_pregunta, 'opcion' => 'Hoja de control', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta3->id_pregunta, 'opcion' => 'Acta electoral', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta3->id_pregunta, 'opcion' => 'Certificado de escrutinio', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta3->id_pregunta, 'opcion' => 'Reporte de veeduría', 'es_correcta' => false, 'orden' => 4]);

        $pregunta4 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué se debe hacer si una persona no aparece en el padrón?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta4->id_pregunta, 'opcion' => 'Permitirle votar igualmente', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta4->id_pregunta, 'opcion' => 'Notificar al notario electoral', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta4->id_pregunta, 'opcion' => 'Llenar un acta de observación', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta4->id_pregunta, 'opcion' => 'Devolverle su carnet y dejarlo votar', 'es_correcta' => false, 'orden' => 4]);

        $pregunta5 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Cuándo pueden cerrarse las mesas?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta5->id_pregunta, 'opcion' => 'Exactamente a las 17:00', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta5->id_pregunta, 'opcion' => 'Cuando ya no queden votantes en fila', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta5->id_pregunta, 'opcion' => 'Al llegar al 80% de participación', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta5->id_pregunta, 'opcion' => 'Cuando lo indique el delegado', 'es_correcta' => false, 'orden' => 4]);

        $pregunta6 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué tipo de voto se considera válido?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta6->id_pregunta, 'opcion' => 'Cuando se marca claramente una sola opción', 'es_correcta' => true, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta6->id_pregunta, 'opcion' => 'Cuando hay dos marcas', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta6->id_pregunta, 'opcion' => 'Cuando está en blanco', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta6->id_pregunta, 'opcion' => 'Cuando se escribe un nombre', 'es_correcta' => false, 'orden' => 4]);

        $pregunta7 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué debe hacer un jurado ante disturbios en el recinto?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta7->id_pregunta, 'opcion' => 'Suspender la votación por cuenta propia', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta7->id_pregunta, 'opcion' => 'Avisar inmediatamente al notario electoral o la policía', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta7->id_pregunta, 'opcion' => 'Continuar normalmente', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta7->id_pregunta, 'opcion' => 'Abandonar la mesa', 'es_correcta' => false, 'orden' => 4]);

        $pregunta8 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué valor tiene el servicio de jurado electoral?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta8->id_pregunta, 'opcion' => 'Es remunerado económicamente', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta8->id_pregunta, 'opcion' => 'Es un deber cívico y no remunerado', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta8->id_pregunta, 'opcion' => 'Es opcional', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta8->id_pregunta, 'opcion' => 'Es voluntariado político', 'es_correcta' => false, 'orden' => 4]);

        $pregunta9 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué ocurre si un jurado no asiste a su mesa sin justificación?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta9->id_pregunta, 'opcion' => 'No pasa nada', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta9->id_pregunta, 'opcion' => 'Se reemplaza sin sanción', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta9->id_pregunta, 'opcion' => 'Puede recibir sanciones legales y multa', 'es_correcta' => true, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta9->id_pregunta, 'opcion' => 'Lo decide el partido político', 'es_correcta' => false, 'orden' => 4]);

        $pregunta10 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionJurado->id_capacitacion,
            'pregunta' => '¿Qué principio guía todo el trabajo del jurado electoral?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $pregunta10->id_pregunta, 'opcion' => 'Competencia', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $pregunta10->id_pregunta, 'opcion' => 'Imparcialidad', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $pregunta10->id_pregunta, 'opcion' => 'Afiliación partidaria', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $pregunta10->id_pregunta, 'opcion' => 'Productividad', 'es_correcta' => false, 'orden' => 4]);

        // Capacitación para VEEDORES
        $capacitacionVeedor = Capacitacion::create([
            'titulo' => '🕵️ Curso de Capacitación para Veedores Electorales de Bolivia',
            'descripcion' => 'Curso especializado para ciudadanos que ejercerán como veedores electorales en representación de instituciones. Incluye fundamentos legales, procedimientos de observación y gestión de incidentes.',
            'rol_destino' => 'VEEDOR',
            'estado' => 'ACTIVO',
            'total_niveles' => 3,
            'puntaje_minimo' => 90,
        ]);

        // Niveles para Veedores
        CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'numero_nivel' => 1,
            'titulo' => 'Fundamentos y Rol del Veedor Electoral',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Comprender la función del veedor dentro del proceso electoral.
Conocer el marco legal que regula la observación electoral.
Entender los límites, deberes y derechos del veedor.

CONTENIDOS

1. INTRODUCCIÓN AL ROL DEL VEEDOR

• Definición: observador imparcial del proceso electoral
• Diferencia entre veedor (nacional) y observador internacional
• Importancia de la veeduría: garantizar la transparencia y confianza pública

2. MARCO LEGAL

• Constitución Política del Estado (art. 26 – derecho a participar y fiscalizar)
• Ley del Régimen Electoral N° 026
• Reglamento de Veedurías Electorales del TSE
• Principios: imparcialidad, independencia, objetividad y respeto

3. ATRIBUCIONES DEL VEEDOR

• Observar el desarrollo de la jornada electoral
• Verificar la instalación, votación y escrutinio
• Reportar irregularidades mediante el formulario oficial
• No intervenir en decisiones de mesa

4. DERECHOS Y DEBERES

Derechos:
• Acceso a recintos y mesas asignadas
• Solicitar información al notario electoral
• Acreditación y uso de credencial oficial

Deberes:
• No influir en los votantes ni en jurados
• Mantener la neutralidad y discreción
• Reportar hechos con veracidad y evidencia

MATERIAL AUDIOVISUAL

Para complementar este nivel, te recomendamos ver el siguiente video que explica los fundamentos del rol de veedor electoral:

Video: Fundamentos de la Veeduría Electoral",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 20,
            'requiere_completar' => true,
            'archivo_url' => 'https://youtu.be/Gz2n0eFKyWU',
        ]);

        CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'numero_nivel' => 2,
            'titulo' => 'Observación del Proceso Electoral',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Aplicar los procedimientos de observación en cada fase de la elección.
Registrar incidencias correctamente.
Coordinar con autoridades sin interferir en el proceso.

CONTENIDOS

1. FASE PREVIA

• Verificación de la apertura de mesa (hora, material, jurados presentes)
• Observación de la presencia de delegados partidarios
• Revisión de accesibilidad del recinto

2. DURANTE LA VOTACIÓN

• Supervisar la atención a los votantes
• Comprobar la confidencialidad del voto
• Identificar actos de presión, propaganda o proselitismo
• Documentar irregularidades (fotografía, hora, descripción)

3. CIERRE Y ESCRUTINIO

• Verificar que se cierre después de atender a los últimos votantes
• Observar el conteo y llenado de actas
• Registrar discrepancias entre delegados o jurados
• No firmar actas ni intervenir directamente

4. ENTREGA DE INFORME

• Redactar informe de veeduría: datos, observaciones, recomendaciones
• Envío al TED o institución que respalda la observación
• Resguardo de la confidencialidad y objetividad",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 25,
            'requiere_completar' => true,
        ]);

        CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'numero_nivel' => 3,
            'titulo' => 'Ética, Reporte y Responsabilidad Institucional',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Desarrollar el criterio ético y técnico del veedor.
Manejar incidentes con serenidad y apego al reglamento.
Elaborar informes precisos y útiles para la transparencia electoral.

CONTENIDOS

1. ÉTICA DEL VEEDOR

• Principio de imparcialidad y respeto a todas las fuerzas políticas
• Prohibición de emitir opiniones públicas durante el proceso
• Confidencialidad de información sensible
• Valor del compromiso cívico

2. GESTIÓN DE INCIDENTES

• Procedimiento ante conflictos o irregularidades:
  1. Observar sin intervenir
  2. Registrar hora, mesa y descripción
  3. Comunicar al notario electoral o autoridad competente
• Ejemplos de incidentes: votación doble, propaganda, hostigamiento, omisión de actas

3. ELABORACIÓN DEL INFORME FINAL

• Estructura:
  1. Datos del veedor e institución
  2. Descripción del recinto y ambiente
  3. Observaciones objetivas
  4. Conclusiones y recomendaciones
• Firma y entrega al TED o institución respaldante

4. RESPALDO INSTITUCIONAL

• Los veedores actúan en representación de una institución, partido o colectivo acreditado
• Cada institución debe garantizar la capacitación y conducta ética de sus observadores
• Responsabilidad compartida ante falsos informes o conductas indebidas",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 30,
            'requiere_completar' => true,
        ]);

        // Preguntas del quiz para Veedores
        $preguntaV1 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Cuál es la principal función del veedor electoral?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV1->id_pregunta, 'opcion' => 'Reemplazar jurados en caso de ausencia', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV1->id_pregunta, 'opcion' => 'Observar el proceso electoral de manera imparcial', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV1->id_pregunta, 'opcion' => 'Recolectar votos', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV1->id_pregunta, 'opcion' => 'Contar los votos junto al presidente de mesa', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV2 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Quién acredita oficialmente a un veedor?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV2->id_pregunta, 'opcion' => 'El partido político', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV2->id_pregunta, 'opcion' => 'El Tribunal Supremo Electoral', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV2->id_pregunta, 'opcion' => 'Los jurados', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV2->id_pregunta, 'opcion' => 'El notario electoral', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV3 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Qué debe hacer un veedor ante una irregularidad?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV3->id_pregunta, 'opcion' => 'Intervenir directamente en la mesa', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV3->id_pregunta, 'opcion' => 'Tomar fotos y difundir en redes sociales', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV3->id_pregunta, 'opcion' => 'Registrar el hecho y reportarlo al notario electoral', 'es_correcta' => true, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV3->id_pregunta, 'opcion' => 'Retirarse del recinto', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV4 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Qué principio guía toda acción del veedor?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV4->id_pregunta, 'opcion' => 'Neutralidad', 'es_correcta' => true, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV4->id_pregunta, 'opcion' => 'Lealtad partidaria', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV4->id_pregunta, 'opcion' => 'Productividad', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV4->id_pregunta, 'opcion' => 'Competitividad', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV5 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Puede un veedor influir en la decisión de un jurado?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV5->id_pregunta, 'opcion' => 'Sí, si observa un error', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV5->id_pregunta, 'opcion' => 'No, debe limitarse a observar y reportar', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV5->id_pregunta, 'opcion' => 'Solo si el notario lo permite', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV5->id_pregunta, 'opcion' => 'Depende del recinto', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV6 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Qué debe incluir el informe de veeduría?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV6->id_pregunta, 'opcion' => 'Opiniones personales', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV6->id_pregunta, 'opcion' => 'Datos del recinto y observaciones objetivas', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV6->id_pregunta, 'opcion' => 'Resultados de mesa', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV6->id_pregunta, 'opcion' => 'Nombres de votantes', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV7 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Cuál de los siguientes comportamientos es incorrecto?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV7->id_pregunta, 'opcion' => 'Observar discretamente el conteo', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV7->id_pregunta, 'opcion' => 'Fotografiar el proceso sin interferir', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV7->id_pregunta, 'opcion' => 'Hacer campaña o expresar preferencia política', 'es_correcta' => true, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV7->id_pregunta, 'opcion' => 'Entregar el informe institucional', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV8 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Qué ocurre si el veedor altera información en su informe?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV8->id_pregunta, 'opcion' => 'No pasa nada', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV8->id_pregunta, 'opcion' => 'Se le retira la acreditación y puede recibir sanciones', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV8->id_pregunta, 'opcion' => 'Solo se corrige el informe', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV8->id_pregunta, 'opcion' => 'Lo decide su institución', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV9 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Qué debe hacer el veedor si un votante con discapacidad requiere ayuda?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV9->id_pregunta, 'opcion' => 'Asistirlo directamente', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV9->id_pregunta, 'opcion' => 'Permitir que lo asista el jurado según procedimiento', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV9->id_pregunta, 'opcion' => 'Llamar a un delegado partidario', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV9->id_pregunta, 'opcion' => 'Retirarse para no interferir', 'es_correcta' => false, 'orden' => 4]);

        $preguntaV10 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionVeedor->id_capacitacion,
            'pregunta' => '¿Qué documento habilita oficialmente al veedor para ingresar al recinto?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaV10->id_pregunta, 'opcion' => 'Su cédula de identidad', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV10->id_pregunta, 'opcion' => 'La credencial de veedor emitida por el TED', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV10->id_pregunta, 'opcion' => 'La carta de su partido', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaV10->id_pregunta, 'opcion' => 'Su informe de veeduría', 'es_correcta' => false, 'orden' => 4]);

        // Capacitación para DELEGADOS
        $capacitacionDelegado = Capacitacion::create([
            'titulo' => '🎖️ Curso de Capacitación para Delegados Electorales de Bolivia',
            'descripcion' => 'Curso especializado para ciudadanos que ejercerán como delegados de organizaciones políticas en las mesas de votación. Incluye marco normativo, desempeño durante la jornada electoral y ética profesional.',
            'rol_destino' => 'DELEGADO',
            'estado' => 'ACTIVO',
            'total_niveles' => 3,
            'puntaje_minimo' => 90,
        ]);

        // Niveles para Delegados
        CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'numero_nivel' => 1,
            'titulo' => 'Rol del Delegado y Marco Normativo',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Comprender el papel político y técnico del delegado electoral.
Conocer las normas que rigen su participación en las mesas y recintos.
Distinguir claramente sus derechos y deberes.

CONTENIDOS

1. ¿QUIÉN ES EL DELEGADO ELECTORAL?

• Representante acreditado por una organización política ante las mesas o recintos
• Participa como testigo del proceso electoral, no como autoridad
• Garantiza la transparencia y defiende los intereses de su organización

2. MARCO LEGAL

• Constitución Política del Estado, art. 26: derecho a la participación política
• Ley del Régimen Electoral N° 026, Título II y III
• Reglamento de Delegados Políticos del TSE
• Normas sobre acreditación, límites de actuación y sanciones

3. DESIGNACIÓN Y ACREDITACIÓN

• Los partidos o alianzas registran sus delegados ante el TED
• Se emite credencial oficial con nombre, CI, fotografía y sigla partidaria
• Sin credencial no se permite el ingreso al recinto

4. DERECHOS Y DEBERES

Derechos:
• Estar presente durante todo el proceso electoral
• Observar y registrar cada fase (instalación, votación, conteo)
• Solicitar aclaraciones o formular observaciones ante el jurado
• Recibir copia del acta de escrutinio

Deberes:
• Mantener el respeto y la calma ante los jurados y veedores
• Evitar discusiones o propaganda
• Cumplir las normas de conducta establecidas por el TED
• Usar correctamente su credencial visible

MATERIAL AUDIOVISUAL

Para complementar este nivel, te recomendamos ver el siguiente video que explica el rol y marco normativo del delegado electoral:

Video: Rol y Marco Normativo del Delegado Electoral",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 20,
            'requiere_completar' => true,
            'archivo_url' => 'https://youtu.be/LRAqvl9j6h0',
        ]);

        CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'numero_nivel' => 2,
            'titulo' => 'Desempeño Durante la Jornada Electoral',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Conocer las tareas y límites de actuación durante cada fase del día electoral.
Saber cómo presentar observaciones o reclamos formales.
Asegurar la defensa del voto de su organización sin vulnerar la ley.

CONTENIDOS

1. INSTALACIÓN DE MESA

• Verificar la presencia de jurados titulares
• Observar la apertura del material electoral (urnas, papeletas, actas)
• Asegurarse de que las papeletas estén firmadas y selladas por los jurados

2. DURANTE LA VOTACIÓN

• Supervisar que cada votante se identifique correctamente en el padrón
• Verificar que se respete el voto secreto
• Anotar irregularidades como:
  - votantes repetidos
  - manipulación indebida de papeletas
  - propaganda dentro del recinto
• No interferir ni influir en el proceso

3. ESCRUTINIO Y CONTEO DE VOTOS

• Observar el conteo público, asegurando claridad y transparencia
• Registrar los resultados en su hoja de control partidaria
• Revisar la correcta suma y transcripción a las actas
• Puede formular observaciones por escrito en el acta antes de la firma final

4. FIRMA Y RECEPCIÓN DE ACTAS

• El delegado puede solicitar una copia del acta oficial para su partido
• Debe firmar únicamente como testigo, no como autoridad
• Debe verificar que todas las hojas estén completas y legibles

MATERIAL AUDIOVISUAL

Para complementar este nivel, te recomendamos ver el siguiente video que muestra el desempeño práctico del delegado durante la jornada electoral:

Video: Desempeño del Delegado en la Jornada Electoral",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 25,
            'requiere_completar' => true,
            'archivo_url' => 'https://youtu.be/j04yFfDtYME',
        ]);

        CapacitacionNivel::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'numero_nivel' => 3,
            'titulo' => 'Ética, Transparencia y Resolución de Conflictos',
            'contenido' => "OBJETIVOS DE APRENDIZAJE

Aplicar principios éticos de representación política y respeto al proceso.
Conocer cómo actuar frente a incidentes, errores o conflictos.
Fortalecer la transparencia partidaria y la rendición de cuentas.

CONTENIDOS

1. ÉTICA Y CONDUCTA DEL DELEGADO

• Representar con disciplina, respeto y responsabilidad
• Abstenerse de confrontaciones verbales o físicas
• Prohibición de uso de celulares para difundir información parcial o falsa
• Cuidado con la confidencialidad de actas y datos internos

2. MANEJO DE INCIDENTES

• En caso de irregularidad grave:
  1. Registrar la observación (hora, mesa, descripción)
  2. Comunicar al notario electoral
  3. Formular observación escrita en el acta si corresponde
• Ejemplos: papeletas faltantes, votos anulados sin causa, discrepancias en conteo

3. TRANSPARENCIA Y COORDINACIÓN

• Colaboración con jurados, veedores y notarios bajo trato cordial
• Promoción de la transparencia electoral como valor democrático
• Comunicación interna con el partido para reportes centralizados

4. RESPONSABILIDAD INSTITUCIONAL

• El delegado no actúa a título personal, sino como representante político
• Todo reporte debe ser fiel, objetivo y verificable
• Conductas indebidas pueden acarrear retiro de credencial y sanción",
            'tipo_contenido' => 'TEXTO',
            'duracion_minutos' => 30,
            'requiere_completar' => true,
        ]);

        // Preguntas del quiz para Delegados
        $preguntaD1 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Quién designa a los delegados electorales?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD1->id_pregunta, 'opcion' => 'Los jurados de mesa', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD1->id_pregunta, 'opcion' => 'Las organizaciones políticas', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD1->id_pregunta, 'opcion' => 'El Tribunal Supremo Electoral', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD1->id_pregunta, 'opcion' => 'Los veedores', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD2 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Cuál es la principal función del delegado?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD2->id_pregunta, 'opcion' => 'Dirigir el conteo de votos', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD2->id_pregunta, 'opcion' => 'Representar a su organización y observar el proceso', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD2->id_pregunta, 'opcion' => 'Firmar las actas como autoridad', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD2->id_pregunta, 'opcion' => 'Emitir comunicados de prensa', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD3 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Qué documento acredita oficialmente al delegado?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD3->id_pregunta, 'opcion' => 'Carta del partido', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD3->id_pregunta, 'opcion' => 'Credencial emitida por el TED', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD3->id_pregunta, 'opcion' => 'Copia de acta', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD3->id_pregunta, 'opcion' => 'Carnet de identidad', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD4 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Puede un delegado manipular papeletas?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD4->id_pregunta, 'opcion' => 'Sí, si observa errores', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD4->id_pregunta, 'opcion' => 'No, solo observar y reportar', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD4->id_pregunta, 'opcion' => 'Solo con permiso del jurado', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD4->id_pregunta, 'opcion' => 'En ningún momento', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD5 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Qué debe hacer si nota irregularidades en la votación?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD5->id_pregunta, 'opcion' => 'Interrumpir el proceso', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD5->id_pregunta, 'opcion' => 'Registrar y comunicar al notario electoral', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD5->id_pregunta, 'opcion' => 'Publicar en redes sociales', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD5->id_pregunta, 'opcion' => 'Abandonar el recinto', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD6 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Cuándo puede firmar el delegado el acta de escrutinio?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD6->id_pregunta, 'opcion' => 'Antes del conteo', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD6->id_pregunta, 'opcion' => 'Solo al final, como testigo', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD6->id_pregunta, 'opcion' => 'Al inicio de la jornada', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD6->id_pregunta, 'opcion' => 'En cualquier momento', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD7 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Qué conducta está prohibida para un delegado?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD7->id_pregunta, 'opcion' => 'Registrar datos del conteo', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD7->id_pregunta, 'opcion' => 'Dialogar respetuosamente con jurados', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD7->id_pregunta, 'opcion' => 'Hacer propaganda partidaria', 'es_correcta' => true, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD7->id_pregunta, 'opcion' => 'Anotar observaciones', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD8 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Qué debe hacer si un jurado comete un error al llenar el acta?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD8->id_pregunta, 'opcion' => 'Corregirlo él mismo', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD8->id_pregunta, 'opcion' => 'Notificar al notario electoral', 'es_correcta' => true, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD8->id_pregunta, 'opcion' => 'Ignorarlo', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD8->id_pregunta, 'opcion' => 'Tomar el acta', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD9 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Cuál es el principio fundamental que debe guiar al delegado?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD9->id_pregunta, 'opcion' => 'Lealtad partidaria y transparencia', 'es_correcta' => true, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD9->id_pregunta, 'opcion' => 'Competencia electoral', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD9->id_pregunta, 'opcion' => 'Silencio total', 'es_correcta' => false, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD9->id_pregunta, 'opcion' => 'Neutralidad absoluta', 'es_correcta' => false, 'orden' => 4]);

        $preguntaD10 = QuizPregunta::create([
            'id_capacitacion' => $capacitacionDelegado->id_capacitacion,
            'pregunta' => '¿Qué puede causar la pérdida de acreditación de un delegado?',
            'tipo' => 'MULTIPLE',
            'puntos' => 1,
            'activa' => true,
        ]);

        QuizRespuesta::create(['id_pregunta' => $preguntaD10->id_pregunta, 'opcion' => 'Llegar tarde', 'es_correcta' => false, 'orden' => 1]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD10->id_pregunta, 'opcion' => 'Faltar sin aviso', 'es_correcta' => false, 'orden' => 2]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD10->id_pregunta, 'opcion' => 'Interferir o alterar el proceso', 'es_correcta' => true, 'orden' => 3]);
        QuizRespuesta::create(['id_pregunta' => $preguntaD10->id_pregunta, 'opcion' => 'Observar desde lejos', 'es_correcta' => false, 'orden' => 4]);
    }
}