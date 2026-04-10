from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm
from reportlab.lib.colors import HexColor, white, black
from reportlab.platypus import (SimpleDocTemplate, Paragraph, Spacer, Table,
                                 TableStyle, PageBreak, HRFlowable)
from reportlab.lib.enums import TA_CENTER, TA_LEFT, TA_JUSTIFY
from reportlab.platypus import KeepTogether

MORADO  = HexColor("#4C1D95")
DORADO  = HexColor("#D97706")
GRIS    = HexColor("#F3F0FF")
MORADO2 = HexColor("#6D28D9")
NEGRO   = HexColor("#0F0F0F")

doc = SimpleDocTemplate(
    "C:/xampp/htdocs/LegendaryClass/LegendaryClass_PlanMarketing.pdf",
    pagesize=A4,
    rightMargin=2.54*cm, leftMargin=2.54*cm,
    topMargin=2.54*cm, bottomMargin=2.54*cm,
)

styles = getSampleStyleSheet()

def sty(name, parent="Normal", **kw):
    return ParagraphStyle(name, parent=styles[parent], **kw)

titulo_doc   = sty("titulo_doc",   fontSize=22, textColor=MORADO, spaceAfter=4, leading=26, alignment=TA_CENTER, fontName="Helvetica-Bold")
subtitulo    = sty("subtitulo",    fontSize=13, textColor=DORADO,  spaceAfter=2, leading=16, alignment=TA_CENTER, fontName="Helvetica-Bold")
autor        = sty("autor",        fontSize=11, textColor=NEGRO,   spaceAfter=2, leading=14, alignment=TA_CENTER)
cap_titulo   = sty("cap_titulo",   fontSize=16, textColor=white,   spaceAfter=6, leading=20, alignment=TA_LEFT, fontName="Helvetica-Bold", backColor=MORADO, borderPadding=(6,8,6,8))
sec_titulo   = sty("sec_titulo",   fontSize=13, textColor=MORADO,  spaceAfter=4, leading=16, fontName="Helvetica-Bold", spaceBefore=10)
sub_titulo   = sty("sub_titulo",   fontSize=11, textColor=DORADO,  spaceAfter=3, leading=14, fontName="Helvetica-Bold", spaceBefore=6)
body         = sty("body",         fontSize=10, textColor=NEGRO,   spaceAfter=4, leading=14, alignment=TA_JUSTIFY)
bullet_style = sty("bullet_style", fontSize=10, textColor=NEGRO,   spaceAfter=2, leading=13, leftIndent=16, bulletIndent=4)
nota         = sty("nota",         fontSize=9,  textColor=MORADO2, spaceAfter=4, leading=12, fontName="Helvetica-Oblique")

story = []

def hr():
    return HRFlowable(width="100%", thickness=1, color=DORADO, spaceAfter=6, spaceBefore=4)

def cap(texto):
    story.append(Paragraph(texto, cap_titulo))
    story.append(Spacer(1, 0.3*cm))

def sec(texto):
    story.append(Paragraph(texto, sec_titulo))

def sub(texto):
    story.append(Paragraph(texto, sub_titulo))

def p(texto):
    story.append(Paragraph(texto, body))

def bl(items):
    for item in items:
        story.append(Paragraph(u"\u2022  " + item, bullet_style))

def sp(n=0.3):
    story.append(Spacer(1, n*cm))

# ─── PORTADA ─────────────────────────────────────────────────────
story.append(Spacer(1, 2*cm))
story.append(Paragraph("PLAN DE MARKETING", titulo_doc))
story.append(Paragraph("LegendaryClass", sty("lc", fontSize=30, textColor=DORADO, fontName="Helvetica-Bold", alignment=TA_CENTER, spaceAfter=4)))
story.append(Paragraph("<i>\"Donde el aprendizaje se convierte en leyenda\"</i>", subtitulo))
story.append(Spacer(1, 1*cm))
story.append(hr())
story.append(Spacer(1, 0.5*cm))
story.append(Paragraph("Capitulos 1 al 4", sty("c14", fontSize=14, textColor=MORADO, fontName="Helvetica-Bold", alignment=TA_CENTER)))
story.append(Spacer(1, 1*cm))

integrantes = [
    "Aguirre Saavedra, Juan Alexis",
    "Alfonso Solorzano, Samir Haziel",
    "Galvan Morales, Luis Enrique",
    "Galvan Guerrero, Matias",
]
for nombre in integrantes:
    story.append(Paragraph(nombre, autor))

story.append(Spacer(1, 1.5*cm))
info = [
    ["Curso:",   "Marketing y Comercializacion de Nuevos Productos"],
    ["Docente:", "Mg. Miluska Horna Elera"],
    ["Carrera:", "Diseno y Desarrollo de Software"],
    ["Ano:",     "2026"],
]
t = Table(info, colWidths=[3.5*cm, 11*cm])
t.setStyle(TableStyle([
    ("FONTSIZE",   (0,0),(-1,-1), 11),
    ("TEXTCOLOR",  (0,0),(0,-1), MORADO),
    ("FONTNAME",   (0,0),(0,-1), "Helvetica-Bold"),
    ("TEXTCOLOR",  (1,0),(1,-1), NEGRO),
    ("ALIGN",      (0,0),(-1,-1), "LEFT"),
    ("VALIGN",     (0,0),(-1,-1), "MIDDLE"),
    ("ROWBACKGROUNDS", (0,0),(-1,-1), [GRIS, white]),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(t)
story.append(PageBreak())

# ─── CAPITULO 1 ───────────────────────────────────────────────────
cap("CAPITULO 1: INTRODUCCION")

sec("Nombre de la Empresa")
story.append(Paragraph("<b>LegendaryClass</b>", sty("emp", fontSize=12, textColor=DORADO, fontName="Helvetica-Bold", spaceAfter=6)))
sp()

sec("Mision")
p("Transformar la experiencia educativa en instituciones escolares mediante una plataforma de gamificacion que motive a los estudiantes, empodere a los docentes y mantenga a las familias conectadas con el progreso academico, convirtiendo el aprendizaje cotidiano en una aventura epica.")
sp()

sec("Vision")
p("Ser la plataforma de gamificacion educativa lider en Latinoamerica para el 2030, presente en mas de 500 instituciones educativas y reconocida por elevar el compromiso estudiantil y el rendimiento academico a traves de la innovacion tecnologica.")
sp()

sec("Valores")
bl([
    "<b>Innovacion:</b> Buscamos constantemente nuevas formas de hacer el aprendizaje mas atractivo y efectivo.",
    "<b>Compromiso:</b> Nos dedicamos al exito educativo de cada institucion que confia en nuestra plataforma.",
    "<b>Accesibilidad:</b> Desarrollamos soluciones adaptables a la realidad economica y tecnologica de los colegios peruanos.",
    "<b>Transparencia:</b> Brindamos informacion clara y honesta sobre el progreso de cada estudiante.",
    "<b>Colaboracion:</b> Fomentamos el trabajo conjunto entre directores, maestros, alumnos y familias.",
])
sp()

sec("Objetivo General")
p("Disenar una estrategia de marketing integral para el lanzamiento de LegendaryClass como plataforma de gamificacion educativa B2B dirigida a instituciones de educacion basica regular en el Peru, estableciendo modelos de comercializacion sostenibles y escalables.")
sp()

sec("Objetivos Especificos")
bl([
    "Identificar y segmentar el mercado objetivo de colegios privados en Lima Metropolitana para establecer propuestas de valor diferenciadas segun el tamano y capacidad economica de cada institucion.",
    "Definir una estrategia de precios dual (suscripcion SaaS e implementacion personalizada) que contemple los costos operativos reales y sea competitiva frente a alternativas extranjeras.",
    "Disenar un plan de comunicacion y promocion digital orientado a directores y coordinadores academicos que genere leads calificados durante el primer ano de operacion.",
])
sp()

sec("Descripcion del Producto")
p("LegendaryClass es una plataforma web de gamificacion educativa que transforma el aula tradicional en una experiencia de juego de rol (RPG). Los estudiantes crean personajes con clases unicas (Mago, Guerrero, Ninja, Arquero, Lanzador), acumulan puntos de experiencia, suben de nivel, completan misiones y canjean recompensas. Los docentes registran comportamientos positivos y negativos, gestionan aulas virtuales y generan reportes de rendimiento. Los directores monitorean toda la institucion en tiempo real, y los padres pueden seguir el progreso academico y conductual de sus hijos. La plataforma es 100% web, responsive y en espanol, adaptable a la identidad visual de cada colegio.")

story.append(PageBreak())

# ─── CAPITULO 2 ───────────────────────────────────────────────────
cap("CAPITULO 2: ANALISIS DEL MACROENTORNO")

sec("Analisis PESTEL")
sp(0.2)

sub("Factores Politicos")
bl([
    "El Ministerio de Educacion del Peru (MINEDU) promueve activamente la transformacion digital en el sistema educativo a traves de programas como Aprendo en Casa y la agenda de digitalizacion post-pandemia.",
    "Existen iniciativas gubernamentales de dotacion de equipos tecnologicos en colegios publicos (PRONIED), lo que amplia el mercado potencial.",
    "Las regulaciones sobre proteccion de datos personales de menores de edad (Ley N 29733) exigen medidas especificas de seguridad que LegendaryClass debe cumplir obligatoriamente.",
    "La inestabilidad politica recurrente en el Peru puede afectar las decisiones de inversion en tecnologia de colegios que dependen de presupuestos estatales.",
])
sp()

sub("Factores Economicos")
bl([
    "El mercado global de EdTech alcanzo los USD 142 mil millones en 2023 y se proyecta superar los USD 350 mil millones para 2030 (HolonIQ, 2023), con Latinoamerica como una de las regiones de mayor crecimiento.",
    "La recuperacion economica post-pandemia ha incrementado la disposicion de colegios privados a invertir en herramientas tecnologicas que los diferencien competitivamente.",
    "La fluctuacion del tipo de cambio sol/dolar encarece las alternativas extranjeras (como Classcraft, que cobra en USD), generando una ventaja para una solucion local en soles.",
    "Los colegios de nivel socioeconomico B y C son el segmento con mayor volumen, pero sensibles al precio, lo que exige modelos de pago flexibles.",
])
sp()

sub("Factores Sociales")
bl([
    "La Generacion Z (nacidos entre 1997-2012) y la Generacion Alpha (2013 en adelante) son nativos digitales habituados a dinamicas de videojuegos, lo que hace que la gamificacion sea una estrategia con alta receptividad.",
    "Existe un creciente problema de desmotivacion y burnout estudiantil en Peru, especialmente en nivel secundaria, que plataformas de gamificacion pueden contribuir a reducir.",
    "Los padres de familia en zonas urbanas demandan mayor visibilidad del comportamiento y rendimiento de sus hijos.",
    "La brecha digital entre colegios urbanos y rurales limita la expansion inicial al ambito metropolitano.",
])
sp()

sub("Factores Tecnologicos")
bl([
    "La penetracion de internet en Lima Metropolitana supera el 80% en hogares (INEI, 2023), y la mayoria de colegios privados cuenta con conectividad aceptable.",
    "La expansion del uso de smartphones y tablets en estudiantes facilita el acceso a plataformas web responsive.",
    "Los principales competidores internacionales (ClassDojo, Classcraft, Kahoot!) han validado globalmente la demanda por herramientas de gamificacion educativa.",
    "Las tecnologias utilizadas (Laravel 11, MongoDB, TailwindCSS) son modernas, escalables y con amplia comunidad de soporte.",
])
sp()

sub("Factores Ecologicos")
bl([
    "LegendaryClass es una solucion 100% digital, lo que elimina el uso de papeles, tarjetas fisicas de puntos y otros materiales frecuentes en sistemas de recompensa tradicionales.",
    "La operacion en servidores cloud permite optar por proveedores con certificaciones de sostenibilidad.",
    "Este posicionamiento eco-friendly puede ser un argumento adicional para instituciones con valores de responsabilidad ambiental.",
])
sp()

sub("Factores Legales")
bl([
    "La Ley de Proteccion de Datos Personales (Ley N 29733) y su reglamento regulan el tratamiento de datos de menores de edad, requiriendo consentimiento de padres o tutores.",
    "Es necesario formalizar la empresa (SAC o similar) y establecer contratos de servicio claros con clausulas de SLA, privacidad y propiedad intelectual.",
    "Los derechos de autor del software deben registrarse en INDECOPI para proteger la propiedad intelectual del equipo.",
    "El cumplimiento de la Ley de Firmas y Certificados Digitales facilita la contratacion y firma de contratos de manera remota.",
])
sp()

sec("Impacto del Macroentorno en el Producto")
p("El contexto actual es altamente favorable para el lanzamiento de LegendaryClass. La digitalizacion educativa acelerada, la generacion nativa digital como usuario final, y la debilidad de las alternativas extranjeras frente a una solucion local en soles y en espanol crean una ventana de oportunidad clara. El principal riesgo a gestionar es el cumplimiento de la normativa de proteccion de datos de menores, que debe incorporarse al diseno del sistema antes del lanzamiento comercial.")

story.append(PageBreak())

# ─── CAPITULO 3 ───────────────────────────────────────────────────
cap("CAPITULO 3: SEGMENTACION Y PERFIL DEL CONSUMIDOR")

sec("Segmentacion del Mercado")
sp(0.2)

sub("Segmentacion Geografica")
seg_geo = [
    ["Nivel", "Zona", "Justificacion"],
    ["Primario",   "Lima Metropolitana", "Mayor concentracion de colegios privados con infraestructura digital y capacidad de inversion"],
    ["Secundario", "Arequipa, Trujillo, Piura", "Ciudades con economia dinamica y colegios privados en crecimiento"],
    ["Terciario",  "Resto del pais",  "Expansion a mediano plazo, condicionada a conectividad"],
]
tg = Table(seg_geo, colWidths=[2.5*cm, 5*cm, 8.5*cm])
tg.setStyle(TableStyle([
    ("BACKGROUND",    (0,0),(-1,0), MORADO),
    ("TEXTCOLOR",     (0,0),(-1,0), white),
    ("FONTNAME",      (0,0),(-1,0), "Helvetica-Bold"),
    ("FONTSIZE",      (0,0),(-1,-1), 9),
    ("ROWBACKGROUNDS",(0,1),(-1,-1), [GRIS, white]),
    ("GRID",          (0,0),(-1,-1), 0.5, HexColor("#CCCCCC")),
    ("VALIGN",        (0,0),(-1,-1), "MIDDLE"),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(tg)
sp()
p("El enfoque inicial es Lima Metropolitana, con un universo estimado de mas de 3,500 colegios privados (MINEDU, 2023), de los cuales aproximadamente 1,200 tienen mas de 200 alumnos y presupuesto para herramientas digitales.")
sp()

sub("Segmentacion Demografica")
p("<b>Decisor de compra (cliente B2B):</b>")
bl([
    "Directores y subdirectores academicos, 35-60 anos.",
    "Colegios privados con 150 a 2,000 alumnos.",
    "NSE B y C principalmente.",
    "Con presupuesto anual en tecnologia educativa de S/. 2,000 a S/. 20,000.",
])
p("<b>Usuario final (estudiante):</b>")
bl([
    "8 a 17 anos (primaria alta y secundaria completa).",
    "Usuarios intensivos de smartphones y plataformas digitales.",
    "Familiarizados con mecanicas de videojuegos y apps de recompensas.",
])
p("<b>Usuario operativo (docente):</b>")
bl([
    "25 a 50 anos, con acceso a computadora o tablet en el aula.",
    "Nivel medio de alfabetizacion digital.",
])
sp()

sub("Segmentacion Psicografica")
bl([
    "<b>Directores/Administradores:</b> Instituciones que buscan diferenciarse frente a la competencia escolar, con directivos de mentalidad innovadora y apertura a nuevas metodologias.",
    "<b>Docentes:</b> Maestros frustrados con sistemas tradicionales de control de comportamiento (listas en papel, stickers), motivados por el bienestar de sus alumnos.",
    "<b>Padres de familia:</b> Familias que valoran el seguimiento activo del desarrollo academico y conductual de sus hijos.",
])
sp()

sub("Segmentacion Conductual")
seg_cond = [
    ["Variable", "Descripcion"],
    ["Ocasion de uso",   "Diario (comportamientos), semanal (reportes), mensual (analisis institucional)"],
    ["Beneficios buscados", "Motivacion estudiantil, ahorro de tiempo en gestion, diferenciacion institucional"],
    ["Estado de uso",    "Colegios que ya usan ClassDojo o Google Classroom (early adopters tecnologicos)"],
    ["Lealtad",          "Alta una vez adoptado, por el efecto de habituacion y los datos acumulados"],
    ["Actitud",          "Colegios con historial de adopcion de nuevas herramientas pedagogicas"],
]
tc = Table(seg_cond, colWidths=[4.5*cm, 11.5*cm])
tc.setStyle(TableStyle([
    ("BACKGROUND",    (0,0),(-1,0), MORADO),
    ("TEXTCOLOR",     (0,0),(-1,0), white),
    ("FONTNAME",      (0,0),(-1,0), "Helvetica-Bold"),
    ("FONTSIZE",      (0,0),(-1,-1), 9),
    ("ROWBACKGROUNDS",(0,1),(-1,-1), [GRIS, white]),
    ("GRID",          (0,0),(-1,-1), 0.5, HexColor("#CCCCCC")),
    ("VALIGN",        (0,0),(-1,-1), "MIDDLE"),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(tc)
sp()

sec("Perfil del Consumidor Objetivo (Buyer Persona)")
p('<b>"Director Innovador":</b> Rodrigo, 45 anos, director de un colegio privado de 400 alumnos en Surco. Busca mejorar la disciplina y la motivacion de sus alumnos sin aumentar la carga de trabajo de sus maestros. Ya usa Google Workspace pero siente que falta algo que enganche a los estudiantes. Toma decisiones de compra basadas en resultados concretos y referencias de otros colegios. Esta dispuesto a invertir S/. 400-700 mensuales si ve retorno en participacion estudiantil.')

story.append(PageBreak())

# ─── CAPITULO 4 ───────────────────────────────────────────────────
cap("CAPITULO 4: ESTRATEGIAS DE MARKETING MIX")

# PRODUCTO
sec("Producto")
sp(0.2)

sub("Logo y Slogan")
bl([
    "<b>Logo:</b> Escudo medieval con una espada y un libro entrelazados, en colores morado, dorado y negro. Tipografia estilo epico (Cinzel).",
    "<b>Slogan:</b> \"Donde el aprendizaje se convierte en leyenda.\"",
])
sp()

sub("Caracteristicas, Beneficios y Diferenciadores")
tprod = [
    ["Caracteristica", "Beneficio para el colegio"],
    ["Sistema RPG completo (XP, niveles, personajes)", "Aumenta motivacion y asistencia estudiantil"],
    ["Modulo de comportamientos positivos/negativos",  "Reemplaza sistemas manuales de puntos, ahorra tiempo al docente"],
    ["Panel del director con metricas en tiempo real", "Toma de decisiones basada en datos concretos"],
    ["Modulo para padres",                             "Mayor involucramiento familiar en la educacion"],
    ["Importacion masiva de alumnos (Excel)",          "Implementacion rapida sin carga manual"],
    ["Tienda de recompensas personalizable",           "El colegio define sus propias recompensas segun su contexto"],
    ["100% en espanol, adaptado a Peru",               "Sin barreras de idioma ni de moneda"],
    ["Personalizable con marca del colegio (whitelabel)", "El colegio lo siente propio, no generico"],
]
tp = Table(tprod, colWidths=[8*cm, 8*cm])
tp.setStyle(TableStyle([
    ("BACKGROUND",    (0,0),(-1,0), MORADO),
    ("TEXTCOLOR",     (0,0),(-1,0), white),
    ("FONTNAME",      (0,0),(-1,0), "Helvetica-Bold"),
    ("FONTSIZE",      (0,0),(-1,-1), 9),
    ("ROWBACKGROUNDS",(0,1),(-1,-1), [GRIS, white]),
    ("GRID",          (0,0),(-1,-1), 0.5, HexColor("#CCCCCC")),
    ("VALIGN",        (0,0),(-1,-1), "MIDDLE"),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(tp)
sp()

p("<b>Diferenciadores frente a la competencia:</b>")
bl([
    "<b>vs. ClassDojo:</b> LegendaryClass ofrece gamificacion profunda (niveles, personajes, misiones, tienda), no solo stickers digitales. ClassDojo no tiene sistema de XP ni evolucion de personajes.",
    "<b>vs. Classcraft:</b> Cobra en dolares (~USD 3-5 por alumno/mes), esta en ingles y no se adapta al contexto curricular peruano. LegendaryClass es local, en soles y ajustable a cada institucion.",
])
sp()

sub("Propuesta de Valor")
pv_style = sty("pv", fontSize=11, textColor=white, backColor=MORADO, fontName="Helvetica-BoldOblique",
               alignment=TA_CENTER, leading=18, spaceAfter=6, borderPadding=(10,12,10,12))
story.append(Paragraph(
    '"LegendaryClass convierte el salon de clases en una experiencia epica de aprendizaje, '
    'incrementando el compromiso y la motivacion estudiantil, mientras otorga a los docentes '
    'una herramienta agil para gestionar comportamientos y reconocer el esfuerzo, '
    'todo en espanol y al precio de la realidad peruana."',
    pv_style))
sp()

sub("Diseno, Empaque y Marca")
bl([
    "<b>Entregable:</b> Plataforma web sin instalacion, acceso desde cualquier navegador.",
    "<b>Empaque digital:</b> Contrato de servicio + manual de usuario + acceso a capacitacion virtual.",
    "<b>Identidad visual:</b> Paleta morado oscuro / dorado / negro. Tipografias Cinzel y Playfair Display. Elementos de fantasia medieval adaptados al entorno escolar.",
    "<b>Planes diferenciados:</b> Plan Basico (marca LegendaryClass), Plan Premium (whitelabel con logo del colegio).",
])
sp()

# PLAZA
sec("Plaza")
sp(0.2)

sub("Canales de Distribucion")
bl([
    "<b>Canal directo B2B:</b> Visitas presenciales y videollamadas con directores y coordinadores academicos. Canal principal en la fase de lanzamiento.",
    "<b>Canal digital:</b> Landing page con demo interactiva, formulario de solicitud de prueba gratuita y chat de soporte.",
    "<b>Canal indirecto (fase 2):</b> Alianzas con distribuidoras de tecnologia educativa y consultoras pedagogicas.",
])
sp()

sub("Estrategia de Cobertura y Logistica")
bl([
    "<b>Fase 1 (meses 1-6):</b> Foco exclusivo en Lima Metropolitana: Surco, Miraflores, San Borja, San Miguel, Los Olivos, San Juan de Lurigancho.",
    "<b>Fase 2 (meses 7-12):</b> Expansion a Arequipa y Trujillo via implementacion remota.",
    "<b>Logistica:</b> Entrega 100% digital. La implementacion incluye creacion de cuenta institucional, carga inicial de datos, capacitacion de docentes (2 sesiones virtuales o 1 presencial) y soporte tecnico por correo/WhatsApp.",
])
sp()

# PROMOCION
sec("Promocion")
sp(0.2)

sub("Estrategia de Comunicacion")
p("<b>ATL (Above the Line):</b>")
p("No se contempla en la fase inicial por el alto costo frente al presupuesto disponible. Se evaluara publicidad en medios especializados en educacion en una segunda fase.")
sp(0.2)
p("<b>BTL (Below the Line):</b>")
bl([
    "Participacion en ferias de innovacion educativa (ExpoEduca, ferias de colegios).",
    "Demos presenciales en colegios invitados (piloto gratuito de 30 dias).",
    "Talleres gratuitos para docentes sobre gamificacion en el aula.",
    "Material POP digital: brochure descargable, video demo de 2 minutos, infografia de beneficios.",
])
sp(0.2)
p("<b>Digital:</b>")
bl([
    "<b>LinkedIn:</b> Contenido dirigido a directores y coordinadores. Anuncios segmentados por cargo y sector educativo.",
    "<b>Facebook/Instagram:</b> Contenido visual para maestros y padres. Pauta con segmentacion por interes en educacion.",
    "<b>YouTube:</b> Canal con tutoriales, demos del producto y contenido de gamificacion educativa.",
    "<b>Email marketing:</b> Secuencia de correos automatizados para leads que soliciten la demo.",
    "<b>WhatsApp Business:</b> Canal de soporte y seguimiento comercial post-demo.",
])
sp()

# PRECIO
sec("Precio")
sp(0.2)

sub("Estrategia de Precios")
p("Se adopta una <b>estrategia dual</b> segun el perfil del cliente:")
sp(0.2)

p("<b>Modelo 1: Suscripcion SaaS (recurrente mensual/anual)</b>")
precio_saas = [
    ["Plan", "N de alumnos", "Precio mensual", "Precio anual (10% dcto.)"],
    ["Basico",       "Hasta 150",   "S/. 180", "S/. 1,944"],
    ["Estandar",     "151 - 400",   "S/. 350", "S/. 3,780"],
    ["Avanzado",     "401 - 800",   "S/. 580", "S/. 6,264"],
    ["Institucional", "+800",       "S/. 900", "S/. 9,720"],
]
ts = Table(precio_saas, colWidths=[4*cm, 4*cm, 4*cm, 4*cm])
ts.setStyle(TableStyle([
    ("BACKGROUND",    (0,0),(-1,0), MORADO),
    ("TEXTCOLOR",     (0,0),(-1,0), white),
    ("FONTNAME",      (0,0),(-1,0), "Helvetica-Bold"),
    ("FONTSIZE",      (0,0),(-1,-1), 9),
    ("ROWBACKGROUNDS",(0,1),(-1,-1), [GRIS, white]),
    ("GRID",          (0,0),(-1,-1), 0.5, HexColor("#CCCCCC")),
    ("ALIGN",         (1,0),(-1,-1), "CENTER"),
    ("VALIGN",        (0,0),(-1,-1), "MIDDLE"),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(ts)
sp()

p("<b>Modelo 2: Implementacion Personalizada (venta directa / whitelabel)</b>")
precio_vd = [
    ["Tipo de colegio",             "Precio unico", "Incluye"],
    ["Pequeno (hasta 200 alumnos)", "S/. 3,500",   "Personalizacion basica + 3 meses soporte"],
    ["Mediano (201-600 alumnos)",   "S/. 7,500",   "Whitelabel + capacitaciones + 6 meses soporte"],
    ["Grande (+600 alumnos)",       "S/. 15,000",  "Desarrollo a medida + integracion + 12 meses soporte"],
]
tv = Table(precio_vd, colWidths=[5*cm, 3*cm, 8*cm])
tv.setStyle(TableStyle([
    ("BACKGROUND",    (0,0),(-1,0), MORADO),
    ("TEXTCOLOR",     (0,0),(-1,0), white),
    ("FONTNAME",      (0,0),(-1,0), "Helvetica-Bold"),
    ("FONTSIZE",      (0,0),(-1,-1), 9),
    ("ROWBACKGROUNDS",(0,1),(-1,-1), [GRIS, white]),
    ("GRID",          (0,0),(-1,-1), 0.5, HexColor("#CCCCCC")),
    ("VALIGN",        (0,0),(-1,-1), "MIDDLE"),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(tv)
sp()

sub("Tabla de Costos Estimados")
costos = [
    ["Concepto",                            "Costo mensual", "Costo anual"],
    ["Servidor VPS (hosting)",              "S/. 200",  "S/. 2,400"],
    ["Base de datos MongoDB Atlas",         "S/. 120",  "S/. 1,440"],
    ["Dominio + SSL",                       "S/. 5",    "S/. 60"],
    ["Herramientas de soporte",             "S/. 80",   "S/. 960"],
    ["Marketing digital (pauta)",           "S/. 500",  "S/. 6,000"],
    ["Materiales y eventos BTL",            "S/. 200",  "S/. 2,400"],
    ["Capacitaciones a clientes",           "S/. 150",  "S/. 1,800"],
    ["Contingencias y otros",               "S/. 100",  "S/. 1,200"],
    ["TOTAL",                               "S/. 1,355", "S/. 16,260"],
]
tcos = Table(costos, colWidths=[9*cm, 3.5*cm, 3.5*cm])
tcos.setStyle(TableStyle([
    ("BACKGROUND",    (0,0),(-1,0), MORADO),
    ("TEXTCOLOR",     (0,0),(-1,0), white),
    ("FONTNAME",      (0,0),(-1,0), "Helvetica-Bold"),
    ("BACKGROUND",    (0,-1),(-1,-1), DORADO),
    ("TEXTCOLOR",     (0,-1),(-1,-1), white),
    ("FONTNAME",      (0,-1),(-1,-1), "Helvetica-Bold"),
    ("FONTSIZE",      (0,0),(-1,-1), 9),
    ("ROWBACKGROUNDS",(0,1),(-1,-2), [GRIS, white]),
    ("GRID",          (0,0),(-1,-1), 0.5, HexColor("#CCCCCC")),
    ("ALIGN",         (1,0),(-1,-1), "CENTER"),
    ("VALIGN",        (0,0),(-1,-1), "MIDDLE"),
    ("BOTTOMPADDING", (0,0),(-1,-1), 5),
    ("TOPPADDING",    (0,0),(-1,-1), 5),
]))
story.append(tcos)
story.append(Paragraph("<i>Nota: No se incluye costo de desarrollo inicial ya que el equipo es el propio desarrollador. Los sueldos se contemplaran a partir de la fase de crecimiento (ano 2).</i>", nota))
sp()

sub("Punto de Equilibrio")
p("Con un costo operativo de aproximadamente S/. 1,355 mensuales, el punto de equilibrio se alcanza con:")
bl([
    "<b>8 colegios en Plan Basico</b> (8 x S/. 180 = S/. 1,440/mes)",
    "<b>4 colegios en Plan Estandar</b> (4 x S/. 350 = S/. 1,400/mes)",
])
sp()

sub("Justificacion del Precio")
p("Los precios estan posicionados <b>por debajo de Classcraft</b> (que cobra aproximadamente S/. 15-20 por alumno/mes en equivalente), siendo significativamente mas accesibles para la realidad peruana. La estrategia es de <b>valor percibido</b>: el precio no se justifica por costo sino por el retorno en motivacion estudiantil, ahorro de tiempo docente y diferenciacion institucional. El descuento del 10% en pago anual incentiva la retencion a largo plazo y mejora el flujo de caja del negocio.")

doc.build(story)
print("PDF generado OK")
