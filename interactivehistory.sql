--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: history; Type: TABLE; Schema: public; Owner: guilhermesiani; Tablespace: 
--

CREATE TABLE history (
    history_id integer NOT NULL,
    title character(100),
    insert_date timestamp without time zone,
    slug character varying(100) DEFAULT 1 NOT NULL
);


ALTER TABLE history OWNER TO guilhermesiani;

--
-- Name: history_content; Type: TABLE; Schema: public; Owner: guilhermesiani; Tablespace: 
--

CREATE TABLE history_content (
    history_content_id integer NOT NULL,
    history_id integer,
    v_position integer,
    h_position integer,
    next_h_position integer DEFAULT 0,
    content text
);


ALTER TABLE history_content OWNER TO guilhermesiani;

--
-- Name: history_content_history_content_id_seq; Type: SEQUENCE; Schema: public; Owner: guilhermesiani
--

CREATE SEQUENCE history_content_history_content_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE history_content_history_content_id_seq OWNER TO guilhermesiani;

--
-- Name: history_content_history_content_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: guilhermesiani
--

ALTER SEQUENCE history_content_history_content_id_seq OWNED BY history_content.history_content_id;


--
-- Name: history_history_id_seq; Type: SEQUENCE; Schema: public; Owner: guilhermesiani
--

CREATE SEQUENCE history_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE history_history_id_seq OWNER TO guilhermesiani;

--
-- Name: history_history_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: guilhermesiani
--

ALTER SEQUENCE history_history_id_seq OWNED BY history.history_id;


--
-- Name: history_option; Type: TABLE; Schema: public; Owner: guilhermesiani; Tablespace: 
--

CREATE TABLE history_option (
    history_option_id integer NOT NULL,
    history_content_id integer,
    option character varying(100),
    next_h_position integer
);


ALTER TABLE history_option OWNER TO guilhermesiani;

--
-- Name: history_option_history_option_id_seq; Type: SEQUENCE; Schema: public; Owner: guilhermesiani
--

CREATE SEQUENCE history_option_history_option_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE history_option_history_option_id_seq OWNER TO guilhermesiani;

--
-- Name: history_option_history_option_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: guilhermesiani
--

ALTER SEQUENCE history_option_history_option_id_seq OWNED BY history_option.history_option_id;


--
-- Name: history_id; Type: DEFAULT; Schema: public; Owner: guilhermesiani
--

ALTER TABLE ONLY history ALTER COLUMN history_id SET DEFAULT nextval('history_history_id_seq'::regclass);


--
-- Name: history_content_id; Type: DEFAULT; Schema: public; Owner: guilhermesiani
--

ALTER TABLE ONLY history_content ALTER COLUMN history_content_id SET DEFAULT nextval('history_content_history_content_id_seq'::regclass);


--
-- Name: history_option_id; Type: DEFAULT; Schema: public; Owner: guilhermesiani
--

ALTER TABLE ONLY history_option ALTER COLUMN history_option_id SET DEFAULT nextval('history_option_history_option_id_seq'::regclass);


--
-- Data for Name: history; Type: TABLE DATA; Schema: public; Owner: guilhermesiani
--

COPY history (history_id, title, insert_date, slug) FROM stdin;
1	Historia teste                                                                                      	2015-10-12 22:06:20	historia-teste
2	O Covil de Martin Waine                                                                             	\N	o-covil-de-martin-waine
\.


--
-- Data for Name: history_content; Type: TABLE DATA; Schema: public; Owner: guilhermesiani
--

COPY history_content (history_content_id, history_id, v_position, h_position, next_h_position, content) FROM stdin;
1	1	0	0	0	Era uma vez um cara do mau chamado aldemar batista. Saqueador de baladas vip.
2	1	1	0	0	Ele comecou a querer pegar as menininhas solteiras, embora todas o quisessem longe delas.
3	1	2	0	0	Foi quando uma loira bem gata deu moral para o coitado. ele pirou ne vei.
4	1	2	1	0	Foi qunado ele desistiu e foi para a casa.
5	1	3	0	0	E nunca mais quis saber de baladas de novo.
6	1	4	0	0	The end
7	2	0	0	0	Praesent accumsan est et mattis gravida. Aliquam tincidunt lacus fringilla ante interdum pharetra. Aliquam erat volutpat
8	2	1	0	0	Nullam ac laoreet nulla. Quisque iaculis, felis id finibus luctus, augue sapien pretium mauris, ut dapibus urna quam ut diam.
9	2	2	0	0	In interdum sollicitudin luctus. Ut congue neque at vestibulum cursus.
10	2	2	1	0	Nam vitae quam id magna mollis venenatis nec eget magna. Duis eu purus ac lorem sodales bibendum.
11	2	3	0	0	Nam vitae quam id magna mollis venenatis nec eget magna. Duis eu purus ac lorem sodales bibendum. Duis nisl nisl, auctor eget egestas tincidunt, euismod eu mi.
12	2	4	0	0	The End
\.


--
-- Name: history_content_history_content_id_seq; Type: SEQUENCE SET; Schema: public; Owner: guilhermesiani
--

SELECT pg_catalog.setval('history_content_history_content_id_seq', 12, true);


--
-- Name: history_history_id_seq; Type: SEQUENCE SET; Schema: public; Owner: guilhermesiani
--

SELECT pg_catalog.setval('history_history_id_seq', 2, true);


--
-- Data for Name: history_option; Type: TABLE DATA; Schema: public; Owner: guilhermesiani
--

COPY history_option (history_option_id, history_content_id, option, next_h_position) FROM stdin;
1	2	Escolha um	0
2	2	Escolha dois	1
3	8	Escolha dois	1
4	8	Escolha um	0
\.


--
-- Name: history_option_history_option_id_seq; Type: SEQUENCE SET; Schema: public; Owner: guilhermesiani
--

SELECT pg_catalog.setval('history_option_history_option_id_seq', 4, true);


--
-- Name: history_content_history_content_id_key; Type: CONSTRAINT; Schema: public; Owner: guilhermesiani; Tablespace: 
--

ALTER TABLE ONLY history_content
    ADD CONSTRAINT history_content_history_content_id_key UNIQUE (history_content_id);


--
-- Name: history_history_id_key; Type: CONSTRAINT; Schema: public; Owner: guilhermesiani; Tablespace: 
--

ALTER TABLE ONLY history
    ADD CONSTRAINT history_history_id_key UNIQUE (history_id);


--
-- Name: history_content_fk1; Type: FK CONSTRAINT; Schema: public; Owner: guilhermesiani
--

ALTER TABLE ONLY history_content
    ADD CONSTRAINT history_content_fk1 FOREIGN KEY (history_id) REFERENCES history(history_id);


--
-- Name: history_option_fk1; Type: FK CONSTRAINT; Schema: public; Owner: guilhermesiani
--

ALTER TABLE ONLY history_option
    ADD CONSTRAINT history_option_fk1 FOREIGN KEY (history_content_id) REFERENCES history_content(history_content_id);


--
-- Name: public; Type: ACL; Schema: -; Owner: guilhermesiani
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM guilhermesiani;
GRANT ALL ON SCHEMA public TO guilhermesiani;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

