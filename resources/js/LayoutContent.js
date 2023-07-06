import React, { useState } from 'react';
import { createStyles, Header, Container, Group, Burger, Paper, Transition, Alert, Notification } from '@mantine/core';
import { useToggle } from '@mantine/hooks';
import { Link as InertiaLink, usePage } from '@inertiajs/react';
import { ThemeToggle } from './Components/ThemeToggle';
import { AlertCircle, Check } from 'tabler-icons-react';

const HEADER_HEIGHT = 60;

const useStyles = createStyles(theme => ({
  root: {
    position: 'relative',
    zIndex: 1,
    height: HEADER_HEIGHT,
  },

  dropdown: {
    position: 'absolute',
    top: HEADER_HEIGHT,
    left: 0,
    right: 0,
    zIndex: 0,
    borderTopRightRadius: 0,
    borderTopLeftRadius: 0,
    borderTopWidth: 0,
    overflow: 'hidden',

    [theme.fn.largerThan('sm')]: {
      display: 'none',
    },
  },

  header: {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    height: '100%',
  },

  menuItems: {
    [theme.fn.smallerThan('sm')]: {
      display: 'none',
    },
  },

  burger: {
    [theme.fn.largerThan('sm')]: {
      display: 'none',
    },
  },

  logo: {
    textDecoration: 'none',
    color: theme.colorScheme === 'dark' ? 'white' : 'black',
    marginRight: 10,
    fontFamily: 'Fjalla One, sans-serif',
    fontWeight: 'bold',
    fontSize: 18,
    marginTop: 2,
  },

  menuItem: {
    display: 'block',
    lineHeight: 1,
    padding: '8px 12px',
    borderRadius: theme.radius.sm,
    textDecoration: 'none',
    color: theme.colorScheme === 'dark' ? theme.colors.dark[0] : theme.colors.gray[7],
    fontSize: theme.fontSizes.sm,
    fontWeight: 500,

    '&:hover': {
      backgroundColor: theme.colorScheme === 'dark' ? theme.colors.dark[6] : theme.colors.gray[0],
    },

    [theme.fn.smallerThan('sm')]: {
      borderRadius: 0,
      padding: theme.spacing.md,
    },
  },

  menuItemActive: {
    '&, &:hover': {
      backgroundColor:
        theme.colorScheme === 'dark'
          ? theme.fn.rgba(theme.colors[theme.primaryColor][9], 0.25)
          : theme.colors[theme.primaryColor][0],
      color: theme.colors[theme.primaryColor][theme.colorScheme === 'dark' ? 3 : 7],
    },
  },
}));

export default function LayoutContent(props) {
  const { flash, appName } = usePage().props;

  const menuItems = [
    {
      href: '/app',
      title: 'Links',
    },
    {
      href: '/app/links/create',
      title: 'Create Link',
    },
  ];

  const [opened, toggleOpened] = useToggle();
  const { classes, cx } = useStyles();

  const [colorScheme, setColorScheme] = useState('light');
  const toggleColorScheme = value => setColorScheme(value || (colorScheme === 'dark' ? 'light' : 'dark'));

  const items = menuItems.map(menuItem => (
    <InertiaLink
      key={menuItem.title}
      href={menuItem.href}
      className={cx(classes.menuItem, { [classes.menuItemActive]: props.title === menuItem.title })}
      onClick={() => {
        toggleOpened(false);
      }}
    >
      {menuItem.title}
    </InertiaLink>
  ));

  return (
    <>
      <Header className={classes.root}>
        <Container size="lg" className={classes.header}>
          <Burger opened={opened} onClick={() => toggleOpened()} className={classes.burger} size="sm" />

          <Group spacing={5}>
            <InertiaLink href="/app" className={classes.logo}>
              {appName}
            </InertiaLink>

            <Group spacing={5} className={classes.menuItems}>
              {items}
            </Group>
          </Group>

          <ThemeToggle />

          <Transition transition="pop-top-right" duration={200} mounted={opened}>
            {styles => (
              <Paper className={classes.dropdown} withBorder style={styles}>
                {items}
              </Paper>
            )}
          </Transition>
        </Container>
      </Header>

      <Container size="lg">
        {flash?.message && (
          <div style={{ maxWidth: 500, margin: 'auto', marginTop: 20 }}>
            <Alert icon={<AlertCircle size={16} />} color="green">
              {flash.message}
            </Alert>
          </div>
        )}

        {props.children}
      </Container>
    </>
  );
}
