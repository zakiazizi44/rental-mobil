--
-- PostgreSQL database dump
--

\restrict nPr985JDR807WyXjoU447yci4y68nN6706ZzdYRo5GkMvPloFkunIIZTcL04EbK

-- Dumped from database version 16.13
-- Dumped by pg_dump version 16.13

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

ALTER TABLE IF EXISTS ONLY public.payments DROP CONSTRAINT IF EXISTS payments_booking_id_foreign;
ALTER TABLE IF EXISTS ONLY public.cars DROP CONSTRAINT IF EXISTS cars_category_id_foreign;
ALTER TABLE IF EXISTS ONLY public.bookings DROP CONSTRAINT IF EXISTS bookings_user_id_foreign;
ALTER TABLE IF EXISTS ONLY public.bookings DROP CONSTRAINT IF EXISTS bookings_car_id_foreign;
DROP INDEX IF EXISTS public.sessions_user_id_index;
DROP INDEX IF EXISTS public.sessions_last_activity_index;
DROP INDEX IF EXISTS public.jobs_queue_index;
DROP INDEX IF EXISTS public.cache_locks_expiration_index;
DROP INDEX IF EXISTS public.cache_expiration_index;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_pkey;
ALTER TABLE IF EXISTS ONLY public.users DROP CONSTRAINT IF EXISTS users_email_unique;
ALTER TABLE IF EXISTS ONLY public.sessions DROP CONSTRAINT IF EXISTS sessions_pkey;
ALTER TABLE IF EXISTS ONLY public.payments DROP CONSTRAINT IF EXISTS payments_pkey;
ALTER TABLE IF EXISTS ONLY public.password_reset_tokens DROP CONSTRAINT IF EXISTS password_reset_tokens_pkey;
ALTER TABLE IF EXISTS ONLY public.migrations DROP CONSTRAINT IF EXISTS migrations_pkey;
ALTER TABLE IF EXISTS ONLY public.jobs DROP CONSTRAINT IF EXISTS jobs_pkey;
ALTER TABLE IF EXISTS ONLY public.job_batches DROP CONSTRAINT IF EXISTS job_batches_pkey;
ALTER TABLE IF EXISTS ONLY public.failed_jobs DROP CONSTRAINT IF EXISTS failed_jobs_uuid_unique;
ALTER TABLE IF EXISTS ONLY public.failed_jobs DROP CONSTRAINT IF EXISTS failed_jobs_pkey;
ALTER TABLE IF EXISTS ONLY public.categories DROP CONSTRAINT IF EXISTS categories_pkey;
ALTER TABLE IF EXISTS ONLY public.cars DROP CONSTRAINT IF EXISTS cars_pkey;
ALTER TABLE IF EXISTS ONLY public.cars DROP CONSTRAINT IF EXISTS cars_license_plate_unique;
ALTER TABLE IF EXISTS ONLY public.cache DROP CONSTRAINT IF EXISTS cache_pkey;
ALTER TABLE IF EXISTS ONLY public.cache_locks DROP CONSTRAINT IF EXISTS cache_locks_pkey;
ALTER TABLE IF EXISTS ONLY public.bookings DROP CONSTRAINT IF EXISTS bookings_pkey;
ALTER TABLE IF EXISTS ONLY public.bookings DROP CONSTRAINT IF EXISTS bookings_booking_code_unique;
ALTER TABLE IF EXISTS public.users ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.payments ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.migrations ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.failed_jobs ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.categories ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.cars ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.bookings ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE IF EXISTS public.users_id_seq;
DROP TABLE IF EXISTS public.users;
DROP TABLE IF EXISTS public.sessions;
DROP SEQUENCE IF EXISTS public.payments_id_seq;
DROP TABLE IF EXISTS public.payments;
DROP TABLE IF EXISTS public.password_reset_tokens;
DROP SEQUENCE IF EXISTS public.migrations_id_seq;
DROP TABLE IF EXISTS public.migrations;
DROP SEQUENCE IF EXISTS public.jobs_id_seq;
DROP TABLE IF EXISTS public.jobs;
DROP TABLE IF EXISTS public.job_batches;
DROP SEQUENCE IF EXISTS public.failed_jobs_id_seq;
DROP TABLE IF EXISTS public.failed_jobs;
DROP SEQUENCE IF EXISTS public.categories_id_seq;
DROP TABLE IF EXISTS public.categories;
DROP SEQUENCE IF EXISTS public.cars_id_seq;
DROP TABLE IF EXISTS public.cars;
DROP TABLE IF EXISTS public.cache_locks;
DROP TABLE IF EXISTS public.cache;
DROP SEQUENCE IF EXISTS public.bookings_id_seq;
DROP TABLE IF EXISTS public.bookings;
SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: bookings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.bookings (
    id bigint NOT NULL,
    booking_code character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    car_id bigint NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    total_days integer NOT NULL,
    price_per_day numeric(12,2) NOT NULL,
    total_price numeric(12,2) NOT NULL,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: bookings_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.bookings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: bookings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.bookings_id_seq OWNED BY public.bookings.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cars; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cars (
    id bigint NOT NULL,
    category_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    brand character varying(255) NOT NULL,
    model character varying(255) NOT NULL,
    year integer NOT NULL,
    license_plate character varying(255) NOT NULL,
    price_per_day numeric(12,2) NOT NULL,
    capacity integer NOT NULL,
    transmission character varying(255) NOT NULL,
    fuel_type character varying(255) NOT NULL,
    color character varying(255),
    description text,
    facilities text,
    image character varying(255),
    status character varying(255) DEFAULT 'available'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: cars_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.cars_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: cars_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.cars_id_seq OWNED BY public.cars.id;


--
-- Name: categories; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: payments; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    booking_id bigint NOT NULL,
    payment_method character varying(255),
    amount numeric(12,2) NOT NULL,
    payment_proof character varying(255),
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    paid_at timestamp(0) without time zone,
    verified_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'customer'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: bookings id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookings ALTER COLUMN id SET DEFAULT nextval('public.bookings_id_seq'::regclass);


--
-- Name: cars id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cars ALTER COLUMN id SET DEFAULT nextval('public.cars_id_seq'::regclass);


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: bookings; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.bookings (id, booking_code, user_id, car_id, start_date, end_date, total_days, price_per_day, total_price, status, notes, created_at, updated_at) FROM stdin;
1	BK-20260803-IP9PCW	2	2	2026-08-03	2026-08-06	4	350000.00	1400000.00	completed	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
2	BK-20260810-7SCENP	2	1	2026-08-10	2026-08-12	3	250000.00	750000.00	completed	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
3	BK-20260818-CLVKWA	3	3	2026-08-18	2026-08-20	3	900000.00	2700000.00	completed	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
4	BK-20260823-UFTQED	3	4	2026-08-23	2026-08-25	3	1400000.00	4200000.00	completed	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
5	BK-20260826-0TBJUF	2	2	2026-08-26	2026-08-31	6	350000.00	2100000.00	waiting_payment	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
6	BK-20260830-BFXKNL	3	1	2026-08-30	2026-09-02	4	250000.00	1000000.00	payment_verification	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
7	BK-20260830-GPWAQI	2	1	2026-08-30	2026-08-31	2	250000.00	500000.00	confirmed	isi bensin penuh	2026-08-28 17:40:13	2026-08-29 11:11:28
8	BK-20260829-HZ8KE3	2	6	2026-08-29	2026-08-29	1	280000.00	280000.00	waiting_payment	\N	2026-08-29 13:33:54	2026-08-29 13:33:54
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: cars; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cars (id, category_id, name, brand, model, year, license_plate, price_per_day, capacity, transmission, fuel_type, color, description, facilities, image, status, created_at, updated_at) FROM stdin;
2	2	Toyota Avanza 1.5L	Toyota	Avanza 1.5 G AT	2023	B 5678 QWE	350000.00	7	Automatic	Bensin	Silver	MVP keluarga legendaris dengan kabin luas dan nyaman untuk perjalanan jauh.	AC, Radio, Bluetooth, USB, Airbag, Power Steering, Rear AC	cars/kf5VWnA6txCuq7FN4YZnUsfu4mWwvufvCrSTpebs.png	available	2026-08-28 09:51:53	2026-08-28 11:54:37
3	3	Honda CR-V	Honda	CR-V 1.5 Turbo Prestige	2023	B 9012 ASD	900000.00	5	Automatic (CVT)	Bensin	Hitam Metalik	SUV premium dengan performa turbo, nyaman dan modern untuk perjalanan dinas.	AC, Radio, Bluetooth, USB, Airbag, Parkir Sensor, Rear Camera, Roof	cars/l0VZLvmbz6K8H8rFmysmHp4I29rVlpGh5r1gkLUj.png	available	2026-08-28 09:51:53	2026-08-28 11:56:38
10	3	Toyota Fortuner	Toyota	Fortuner 2.4 VRZ	2022	B 2025 LMV	1250000.00	7	Automatic	Diesel	Hitam Metalik	SUV ladder-frame premium dan tangguh, legendaris untuk perjalanan jauh maupun medan berat.	AC, Radio, Bluetooth, USB, Leather Seat, Rear Camera, Cruise Control, Airbag	cars/Xye0EW8DO4AdO4VtowrJMVVJ5sYbaJ48BcEus7UR.png	available	2026-08-28 09:51:53	2026-08-28 12:42:15
4	4	Toyota Camry	Toyota	Camry 2.5 G	2022	B 3456 FGH	1400000.00	5	Automatic	Bensin	Silver	Sedan eksekutif dengan kenyamanan kelas atas, ideal untuk kebutuhan premium.	AC, Radio, Bluetooth, USB, Leather Seat, Airbag, Sunroof, Cruise Control	cars/E22CYDEwQWuFjjASGbLHPBatLGjskKeKMid3SCyW.png	available	2026-08-28 09:51:53	2026-08-28 12:01:11
5	2	Suzuki Ertiga	Suzuki	Ertiga GX AT	2021	B 7890 ZXC	320000.00	7	Automatic	Bensin	Abu-abu	MPV compact yang nyaman dan irit untuk kebutuhan keluarga.	AC, Radio, Bluetooth, USB, Airbag, Power Steering	cars/BM6yyVka2FnZv9B1KRntHwTcT3zXwBbN7dnKzYte.webp	maintenance	2026-08-28 09:51:53	2026-08-28 12:03:17
6	1	Honda Brio	Honda	Brio RS AT	2023	B 1122 JKL	280000.00	5	Automatic (CVT)	Bensin	Putih	City car sporty dengan desain modern dan handling yang menyenangkan.	AC, Radio, Bluetooth, USB, Airbag, Power Steering	cars/ovTi1FF2DRSltUTRkwd4v7JgMb1lKK5hjgDjCG7J.png	available	2026-08-28 09:51:53	2026-08-28 12:20:47
7	5	Toyota Alphard	Toyota	Alphard 2.5 G	2022	B 2022 LMX	2500000.00	7	Automatic	Bensin	Putih	MPV mewah ikonik dengan kabin eksekutif, kursi captain seat, dan kenyamanan kelas jet pribadi.	AC, Radio, Bluetooth, USB, Leather Seat, Sunroof, Rear Camera, Cruise Control, Power Seat	cars/Tjo4IXM3Bd3WCQsoD4WP0zfer8UbS0Cinw5DIDUh.jpg	available	2026-08-28 09:51:53	2026-08-28 12:23:12
8	5	Lexus ES 250	Lexus	ES 250 Luxury	2022	B 2023 LMY	1900000.00	5	Automatic	Bensin	Hitam	Sedan luxury Jepang dengan kabin hening, jok kulit premium, dan teknologi berkendara mutakhir.	AC, Radio, Bluetooth, USB, Leather Seat, Sunroof, Rear Camera, Cruise Control, Memory Seat	cars/u6aOKhbWPi76170X8muucmNTaduVqybaeDDU71ts.jpg	available	2026-08-28 09:51:53	2026-08-28 12:39:37
9	5	Toyota Hiace	Toyota	Hiace Commuter	2022	B 2024 LMZ	1600000.00	15	Manual	Diesel	Putih	Van premium berkapasitas besar, nyaman untuk rombongan, antar-jemput, dan perjalanan wisata.	AC, Radio, Bluetooth, USB, Leather Seat, LCD TV, Rear Camera, Power Steering	cars/eMmDQ3pJIr7apjh8tUiXAYsDx7uoENcPjLRTBWbq.jpg	available	2026-08-28 09:51:53	2026-08-28 12:40:55
11	3	Mitsubishi Pajero Sport	Mitsubishi	Pajero Sport Dakar	2022	B 2026 LMW	1100000.00	7	Automatic	Diesel	Putih	SUV tangguh berkelas dengan desain gagah dan kemampuan off-road yang handal.	AC, Radio, Bluetooth, USB, Leather Seat, Rear Camera, Cruise Control, Airbag	cars/n9zKZLfaU54QyVjUGXFGPzWG4vNhQv0mWngIfo9B.webp	available	2026-08-28 09:51:53	2026-08-28 12:42:47
12	3	Hyundai Creta	Hyundai	Creta Prime	2023	B 2027 LMP	650000.00	5	Automatic	Bensin	Silver	SUV compact modern dengan desain stylish, fitur lengkap, dan nyaman untuk perkotaan.	AC, Radio, Bluetooth, USB, Airbag, Rear Camera, Cruise Control, Power Steering	cars/kyZxQJ7Pwkpsuq2VzOwp4INij2gKSJQNieN5Tgy1.png	available	2026-08-28 09:51:53	2026-08-28 12:43:41
1	1	Daihatsu Ayla 1.2L	Daihatsu	Ayla 1.2 X AT	2022	B 1234 KLZ	250000.00	5	Automatic	Bensin	Kuning	Mobil city car yang irit dan lincah, cocok untuk mobilitas perkotaan.	AC, Radio, Bluetooth, USB, Airbag, Power Steering	cars/BJJj57h54pTNRbNrwqSPq8YQ779kf8Q2A9ga6efJ.png	rented	2026-08-28 09:51:53	2026-08-29 11:11:28
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.categories (id, name, description, created_at, updated_at) FROM stdin;
1	City Car	Mobil mungil hemat BBM, cocok untuk berkendara di dalam kota.	2026-08-28 09:51:53	2026-08-28 09:51:53
2	MPV	Mobil keluarga dengan kabin luas dan kapasitas penumpang besar.	2026-08-28 09:51:53	2026-08-28 09:51:53
3	SUV	Mobil tangguh dengan ground clearance tinggi, cocok untuk berbagai medan.	2026-08-28 09:51:53	2026-08-28 09:51:53
4	Sedan	Mobil elegan dengan kenyamanan berkendara premium.	2026-08-28 09:51:53	2026-08-28 09:51:53
5	Premium / Luxury	Mobil mewah kelas eksekutif dengan kenyamanan, performa, dan kemewahan terbaik.	2026-08-28 09:51:53	2026-08-28 09:51:53
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_01_01_000001_create_categories_table	1
5	2026_01_01_000002_create_cars_table	1
6	2026_01_01_000003_create_bookings_table	1
7	2026_01_01_000004_create_payments_table	1
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.payments (id, booking_id, payment_method, amount, payment_proof, status, paid_at, verified_at, created_at, updated_at) FROM stdin;
1	1	Transfer Bank BCA	1400000.00	\N	verified	2026-07-29 09:51:53	2026-07-30 09:51:53	2026-08-28 09:51:53	2026-08-28 09:51:53
2	2	Transfer Bank BCA	750000.00	\N	verified	2026-07-29 09:51:53	2026-07-30 09:51:53	2026-08-28 09:51:53	2026-08-28 09:51:53
3	3	Transfer Bank BCA	2700000.00	\N	verified	2026-07-29 09:51:53	2026-07-30 09:51:53	2026-08-28 09:51:53	2026-08-28 09:51:53
4	4	Transfer Bank BCA	4200000.00	\N	verified	2026-07-29 09:51:53	2026-07-30 09:51:53	2026-08-28 09:51:53	2026-08-28 09:51:53
5	5	Transfer Bank BCA	2100000.00	\N	pending	\N	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
6	6	Transfer Bank BCA	1000000.00	\N	pending	\N	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
7	7	Transfer Bank BCA	500000.00	payments/Xe6T19Us8UF9DUN74jlV4nnwcJ7X0BMf9DeaBW9e.jpg	verified	2026-08-28 17:40:51	2026-08-29 11:11:28	2026-08-28 17:40:51	2026-08-29 11:11:28
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
m4MlcWCixIvlrL7Nb3Z1uAcW4fSmLAC4jxR4yJF9	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUNqZGNQQXRQSExQaXA3Q3RST1h0UTNZRWtVRm5qY2xVNXh3VkE0SiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9	1788098570
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at) FROM stdin;
1	Admin Rental	admin@rentalmobil.com	\N	$2y$12$fpjAQ8Y1iskgQX4gZtjZeuhbe5PSzx7IKfCru9nfrXIzImdcwZ3xu	admin	\N	2026-08-28 09:51:52	2026-08-28 09:51:52
2	Budi Santoso	customer1@example.com	\N	$2y$12$Q9tAUCmw0SCOVTryJvTIFeKwV5h.a4eS8EptlScdIaM//jHwCqOaG	customer	\N	2026-08-28 09:51:52	2026-08-28 09:51:52
3	Siti Aminah	customer2@example.com	\N	$2y$12$0mXQQPEoezpEIDCUS9QejekV/cDKPbMtVaBqI.5c2nV3Bi9gzSPT6	customer	\N	2026-08-28 09:51:53	2026-08-28 09:51:53
\.


--
-- Name: bookings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.bookings_id_seq', 8, true);


--
-- Name: cars_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.cars_id_seq', 12, true);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.categories_id_seq', 5, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 7, true);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.payments_id_seq', 7, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- Name: bookings bookings_booking_code_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_booking_code_unique UNIQUE (booking_code);


--
-- Name: bookings bookings_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: cars cars_license_plate_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_license_plate_unique UNIQUE (license_plate);


--
-- Name: cars cars_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_pkey PRIMARY KEY (id);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: bookings bookings_car_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_car_id_foreign FOREIGN KEY (car_id) REFERENCES public.cars(id) ON DELETE CASCADE;


--
-- Name: bookings bookings_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: cars cars_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- Name: payments payments_booking_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_booking_id_foreign FOREIGN KEY (booking_id) REFERENCES public.bookings(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict nPr985JDR807WyXjoU447yci4y68nN6706ZzdYRo5GkMvPloFkunIIZTcL04EbK

