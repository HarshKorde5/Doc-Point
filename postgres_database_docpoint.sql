--
-- PostgreSQL database dump
--

-- Dumped from database version 14.15 (Ubuntu 14.15-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.15 (Ubuntu 14.15-0ubuntu0.22.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: admin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin (
    aemail character varying(255) NOT NULL,
    apassword character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.admin OWNER TO postgres;

--
-- Name: appointment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.appointment (
    appoid integer NOT NULL,
    pid integer,
    apponum integer,
    scheduleid integer,
    appodate date
);


ALTER TABLE public.appointment OWNER TO postgres;

--
-- Name: appointment_appoid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.appointment_appoid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.appointment_appoid_seq OWNER TO postgres;

--
-- Name: appointment_appoid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.appointment_appoid_seq OWNED BY public.appointment.appoid;


--
-- Name: doctor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctor (
    docid integer NOT NULL,
    docemail character varying(255),
    docname character varying(255) DEFAULT NULL::character varying,
    docpassword character varying(255) DEFAULT NULL::character varying,
    docnic character varying(15) DEFAULT NULL::character varying,
    doctel character varying(15) DEFAULT NULL::character varying,
    specialties integer
);


ALTER TABLE public.doctor OWNER TO postgres;

--
-- Name: doctor_docid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.doctor_docid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.doctor_docid_seq OWNER TO postgres;

--
-- Name: doctor_docid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.doctor_docid_seq OWNED BY public.doctor.docid;


--
-- Name: patient; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.patient (
    pid integer NOT NULL,
    pemail character varying(255),
    pname character varying(255),
    ppassword character varying(255),
    paddress character varying(255) DEFAULT 'Not Provided'::character varying,
    pnic character varying(15),
    pdob date,
    ptel character varying(15),
    CONSTRAINT patient_pdob_check CHECK ((pdob <= CURRENT_DATE))
);


ALTER TABLE public.patient OWNER TO postgres;

--
-- Name: patient_pid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.patient_pid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.patient_pid_seq OWNER TO postgres;

--
-- Name: patient_pid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.patient_pid_seq OWNED BY public.patient.pid;


--
-- Name: schedule; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.schedule (
    scheduleid integer NOT NULL,
    docid integer NOT NULL,
    title character varying(255) DEFAULT 'General Schedule'::character varying,
    scheduledate date,
    scheduletime time without time zone,
    nop integer DEFAULT 0,
    CONSTRAINT schedule_nop_check CHECK ((nop >= 0))
);


ALTER TABLE public.schedule OWNER TO postgres;

--
-- Name: schedule_scheduleid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.schedule_scheduleid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schedule_scheduleid_seq OWNER TO postgres;

--
-- Name: schedule_scheduleid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.schedule_scheduleid_seq OWNED BY public.schedule.scheduleid;


--
-- Name: specialties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.specialties (
    id integer NOT NULL,
    sname character varying(50) DEFAULT 'General'::character varying
);


ALTER TABLE public.specialties OWNER TO postgres;

--
-- Name: specialties_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.specialties_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.specialties_id_seq OWNER TO postgres;

--
-- Name: specialties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.specialties_id_seq OWNED BY public.specialties.id;


--
-- Name: webuser; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.webuser (
    email character varying(255) NOT NULL,
    usertype character(1) DEFAULT 'p'::bpchar,
    CONSTRAINT check_usertype CHECK ((usertype = ANY (ARRAY['a'::bpchar, 'd'::bpchar, 'p'::bpchar])))
);


ALTER TABLE public.webuser OWNER TO postgres;

--
-- Name: appointment appoid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointment ALTER COLUMN appoid SET DEFAULT nextval('public.appointment_appoid_seq'::regclass);


--
-- Name: doctor docid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor ALTER COLUMN docid SET DEFAULT nextval('public.doctor_docid_seq'::regclass);


--
-- Name: patient pid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patient ALTER COLUMN pid SET DEFAULT nextval('public.patient_pid_seq'::regclass);


--
-- Name: schedule scheduleid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule ALTER COLUMN scheduleid SET DEFAULT nextval('public.schedule_scheduleid_seq'::regclass);


--
-- Name: specialties id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.specialties ALTER COLUMN id SET DEFAULT nextval('public.specialties_id_seq'::regclass);


--
-- Data for Name: admin; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admin (aemail, apassword) FROM stdin;
admin@docpoint.com	123
\.


--
-- Data for Name: appointment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.appointment (appoid, pid, apponum, scheduleid, appodate) FROM stdin;
1	1	1	1	2025-02-03
\.


--
-- Data for Name: doctor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctor (docid, docemail, docname, docpassword, docnic, doctel, specialties) FROM stdin;
1	doctor@docpoint.com	Test Doctor	123	000000000	0110000000	1
\.


--
-- Data for Name: patient; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.patient (pid, pemail, pname, ppassword, paddress, pnic, pdob, ptel) FROM stdin;
1	patient@docpoint.com	Test Patient	123	Mumbai	0000000000	2000-01-01	0120000000
2	harshkorde05@gmail.com	Harsh Korde	123	Pune	0110000000	2022-06-03	0700000000
\.


--
-- Data for Name: schedule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.schedule (scheduleid, docid, title, scheduledate, scheduletime, nop) FROM stdin;
1	1	Test Session	2050-01-01	18:00:00	50
2	1	1	2025-01-18	20:36:00	1
3	1	12	2025-02-15	20:33:00	1
4	1	1	2025-01-23	12:32:00	1
5	1	1	2025-02-01	20:35:00	1
6	1	12	2025-03-02	20:35:00	1
7	1	1	2025-01-24	20:36:00	1
8	1	12	2025-02-10	13:33:00	1
\.


--
-- Data for Name: specialties; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.specialties (id, sname) FROM stdin;
1	Accident and emergency medicine
2	Allergology
3	Anaesthetics
4	Biological hematology
5	Cardiology
6	Child psychiatry
7	Clinical biology
8	Clinical chemistry
9	Clinical neurophysiology
10	Clinical radiology
11	Dental, oral and maxillo-facial surgery
12	Dermato-venerology
13	Dermatology
14	Endocrinology
15	Gastro-enterologic surgery
16	Gastroenterology
17	General hematology
18	General Practice
19	General surgery
20	Geriatrics
21	Immunology
22	Infectious diseases
23	Internal medicine
24	Laboratory medicine
25	Maxillo-facial surgery
26	Microbiology
27	Nephrology
28	Neuro-psychiatry
29	Neurology
30	Neurosurgery
31	Nuclear medicine
32	Obstetrics and gynecology
33	Occupational medicine
34	Ophthalmology
35	Orthopaedics
36	Otorhinolaryngology
37	Paediatric surgery
38	Paediatrics
39	Pathology
40	Pharmacology
41	Physical medicine and rehabilitation
42	Plastic surgery
43	Podiatric Medicine
44	Podiatric Surgery
45	Psychiatry
46	Public health and Preventive Medicine
47	Radiology
48	Radiotherapy
49	Respiratory medicine
50	Rheumatology
51	Stomatology
52	Thoracic surgery
53	Tropical medicine
54	Urology
55	Vascular surgery
56	Venereology
\.


--
-- Data for Name: webuser; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.webuser (email, usertype) FROM stdin;
admin@docpoint.com	a
doctor@docpoint.com	d
patient@docpoint.com	p
harshkorde05@gmail.com	p
\.


--
-- Name: appointment_appoid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.appointment_appoid_seq', 1, false);


--
-- Name: doctor_docid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.doctor_docid_seq', 1, false);


--
-- Name: patient_pid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.patient_pid_seq', 1, false);


--
-- Name: schedule_scheduleid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.schedule_scheduleid_seq', 1, false);


--
-- Name: specialties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.specialties_id_seq', 1, false);


--
-- Name: admin admin_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin
    ADD CONSTRAINT admin_pkey PRIMARY KEY (aemail);


--
-- Name: appointment appointment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointment
    ADD CONSTRAINT appointment_pkey PRIMARY KEY (appoid);


--
-- Name: doctor doctor_docemail_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor
    ADD CONSTRAINT doctor_docemail_key UNIQUE (docemail);


--
-- Name: doctor doctor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor
    ADD CONSTRAINT doctor_pkey PRIMARY KEY (docid);


--
-- Name: patient patient_pemail_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patient
    ADD CONSTRAINT patient_pemail_key UNIQUE (pemail);


--
-- Name: patient patient_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patient
    ADD CONSTRAINT patient_pkey PRIMARY KEY (pid);


--
-- Name: patient patient_pnic_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.patient
    ADD CONSTRAINT patient_pnic_key UNIQUE (pnic);


--
-- Name: schedule schedule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule
    ADD CONSTRAINT schedule_pkey PRIMARY KEY (scheduleid);


--
-- Name: specialties specialties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.specialties
    ADD CONSTRAINT specialties_pkey PRIMARY KEY (id);


--
-- Name: specialties specialties_sname_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.specialties
    ADD CONSTRAINT specialties_sname_key UNIQUE (sname);


--
-- Name: appointment unique_patient_schedule; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointment
    ADD CONSTRAINT unique_patient_schedule UNIQUE (pid, scheduleid);


--
-- Name: webuser webuser_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.webuser
    ADD CONSTRAINT webuser_pkey PRIMARY KEY (email);


--
-- Name: idx_scheduledate; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_scheduledate ON public.schedule USING btree (scheduledate);


--
-- Name: appointment appointment_pid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointment
    ADD CONSTRAINT appointment_pid_fkey FOREIGN KEY (pid) REFERENCES public.patient(pid) ON DELETE CASCADE;


--
-- Name: appointment appointment_scheduleid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointment
    ADD CONSTRAINT appointment_scheduleid_fkey FOREIGN KEY (scheduleid) REFERENCES public.schedule(scheduleid) ON DELETE CASCADE;


--
-- Name: doctor doctor_specialties_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor
    ADD CONSTRAINT doctor_specialties_fkey FOREIGN KEY (specialties) REFERENCES public.specialties(id) ON DELETE SET NULL;


--
-- Name: schedule fk_schedule_docid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule
    ADD CONSTRAINT fk_schedule_docid FOREIGN KEY (docid) REFERENCES public.doctor(docid);


--
-- PostgreSQL database dump complete
--
